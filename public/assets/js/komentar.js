let selectedRating = 0;
const stars = document.querySelectorAll('#starRating span');
const form = document.getElementById('commentForm');
const list = document.getElementById('commentList');
const avgText = document.getElementById('average-rating');
let allRatings = [];

// Fungsi pilih bintang
stars.forEach(star => {
  star.addEventListener('click', () => {
    selectedRating = parseInt(star.dataset.value);
    stars.forEach(s => s.classList.remove('active'));
    for (let i = 0; i < selectedRating; i++) {
      stars[i].classList.add('active');
    }
  });
});

// Fungsi kirim komentar
form.addEventListener('submit', e => {
  e.preventDefault();

  const name = document.getElementById('name').value;
  const comment = document.getElementById('comment').value;

  if (selectedRating === 0) {
    alert("Silakan pilih rating terlebih dahulu ⭐");
    return;
  }

  // Tambahkan komentar ke daftar
  const item = document.createElement('div');
  item.classList.add('comment-item');
  item.innerHTML = `
    <h4>${name}</h4>
    <div class="stars">${'★'.repeat(selectedRating)}${'☆'.repeat(5 - selectedRating)}</div>
    <p>${comment}</p>
  `;
  list.prepend(item);

  // Update rata-rata
  allRatings.push(selectedRating);
  const avg = (allRatings.reduce((a, b) => a + b, 0) / allRatings.length).toFixed(1);
  avgText.textContent = avg;

  // Reset form
  form.reset();
  selectedRating = 0;
  stars.forEach(s => s.classList.remove('active'));
});
