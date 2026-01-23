document.addEventListener('DOMContentLoaded', () => {
  const hamburger = document.querySelector('.hamburger');
  const navMenu = document.querySelector('.nav-menu');
  const navLinks = document.querySelectorAll('.nav-menu a');
  const bookingForm = document.getElementById('bookingForm');
  const navbar = document.querySelector('.navbar');

  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
  });

  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      hamburger.classList.remove('active');
      navMenu.classList.remove('active');
    });
  });

  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        const offsetTop = target.offsetTop - 70;
        window.scrollTo({
          top: offsetTop,
          behavior: 'smooth'
        });
      }
    });
  });

  window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
      navbar.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
    } else {
      navbar.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
    }
  });

  const today = new Date().toISOString().split('T')[0];
  document.getElementById('date').setAttribute('min', today);

  bookingForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = {
      name: document.getElementById('name').value,
      phone: document.getElementById('phone').value,
      service: document.getElementById('service').value,
      date: document.getElementById('date').value,
      time: document.getElementById('time').value,
      notes: document.getElementById('notes').value
    };

    const serviceNames = {
      classic: 'Classic Haircut',
      premium: 'Premium Haircut',
      shaving: 'Shaving & Beard Trim',
      wash: 'Hair Wash',
      coloring: 'Hair Coloring',
      styling: 'Hair Styling'
    };

    const message = `
Booking berhasil!

Nama: ${formData.name}
Telepon: ${formData.phone}
Layanan: ${serviceNames[formData.service]}
Tanggal: ${formData.date}
Waktu: ${formData.time}
${formData.notes ? 'Catatan: ' + formData.notes : ''}

Terima kasih telah melakukan booking. Kami akan menghubungi Anda segera untuk konfirmasi.
    `.trim();

    alert(message);
    bookingForm.reset();
  });

  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, observerOptions);

  document.querySelectorAll('.service-card, .gallery-item, .contact-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'all 0.6s ease';
    observer.observe(el);
  });
});

const barberNameElement = document.getElementById("barberName");
  const commentForm = document.getElementById("commentForm");
  const commentList = document.getElementById("commentList");
  const avgRatingElement = document.getElementById("avgRating");

  // Ambil parameter barber dari URL (contoh: profil.html?id=andi)
  const params = new URLSearchParams(window.location.search);
  const barberId = params.get("id") || "unknown";

  // Nama barber berdasarkan id
  const barberNames = {
    andi: "Andi “The Classic”",
    budi: "Budi “The Fade Master”",
    candra: "Candra “The Stylist”",
    dedi: "Dedi “The Sharp Look”"
  };

  // Tampilkan nama barber di halaman
  barberNameElement.textContent = barberNames[barberId] || "Barber Tidak Dikenal";

  // Ambil komentar dari localStorage
  const comments = JSON.parse(localStorage.getItem("comments")) || {};

  // Pastikan ada array untuk barber ini
  if (!comments[barberId]) comments[barberId] = [];

  // Fungsi render komentar
  function renderComments() {
    commentList.innerHTML = "";
    const barberComments = comments[barberId];

    if (barberComments.length === 0) {
      commentList.innerHTML = "<p>Belum ada komentar untuk barber ini.</p>";
      avgRatingElement.textContent = "-";
      return;
    }

    // Hitung rata-rata rating
    const totalRating = barberComments.reduce((sum, c) => sum + c.rating, 0);
    const avgRating = (totalRating / barberComments.length).toFixed(1);
    avgRatingElement.textContent = `${avgRating} / 5 ⭐`;

    // Tampilkan daftar komentar
    barberComments.forEach(c => {
      const div = document.createElement("div");
      div.className = "comment-item";
      div.innerHTML = `
        <h4>${c.name}</h4>
        <div class="stars">${"⭐".repeat(c.rating)}</div>
        <p>${c.text}</p>
        <small>${new Date(c.date).toLocaleString()}</small>
      `;
      commentList.appendChild(div);
    });
  }

  // Saat form dikirim
  commentForm.addEventListener("submit", e => {
    e.preventDefault();

    const name = document.getElementById("name").value.trim();
    const text = document.getElementById("text").value.trim();
    const rating = parseInt(document.querySelector('input[name="rating"]:checked')?.value || 0);

    if (!name || !text || rating === 0) {
      alert("Harap isi nama, komentar, dan pilih rating.");
      return;
    }

    const newComment = { name, text, rating, date: new Date().toISOString() };

    comments[barberId].push(newComment);
    localStorage.setItem("comments", JSON.stringify(comments));

    commentForm.reset();
    renderComments();
  });

  // Render awal
  renderComments();
