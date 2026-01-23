// ========== FORM BOOKING (untuk user) ==========
const bookingForm = document.getElementById('bookingForm');
if (bookingForm) {
  bookingForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const nama = document.getElementById('nama').value;
    const barber = document.getElementById('barber').value;
    const layanan = document.getElementById('layanan').value;
    const waktu = document.getElementById('waktu').value;

    const newBooking = {
      nama,
      barber,
      layanan,
      waktu,
      status: 'Booked'
    };

    let bookings = JSON.parse(localStorage.getItem('bookings')) || [];
    bookings.push(newBooking);
    localStorage.setItem('bookings', JSON.stringify(bookings));

    alert('Booking berhasil! Kamu akan diarahkan ke halaman admin.');
    window.location.href = 'admin.html';
  });
}

// ========== DASHBOARD ADMIN ==========
const bookingList = document.getElementById('bookingList');
if (bookingList) {
  const bookings = JSON.parse(localStorage.getItem('bookings')) || [];
  let total = bookings.length;

  // tampilkan daftar booking
  bookingList.innerHTML = bookings.map(b => `
    <tr>
      <td>${b.nama}</td>
      <td>${b.barber}</td>
      <td>${b.layanan}</td>
      <td class="status-booked">${b.status}</td>
      <td>${b.waktu}</td>
    </tr>
  `).join('');

  // update ringkasan
  document.getElementById('totalBooking').textContent = total;
  document.getElementById('hariIni').textContent = bookings.filter(b => {
    const tgl = new Date(b.waktu).toISOString().split('T')[0];
    return tgl === new Date().toISOString().split('T')[0];
  }).length;
}
