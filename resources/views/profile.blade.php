<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Pengguna - Barbershop Klasik</title>
  <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo">Barbershop Klasik</div>
    <a href="{{ url('/') }}" class="btn-kembali">Kembali</a>
  </nav>

  <!-- Konten Utama -->
  <section class="profile-layout">

    <!-- Kiri: Profil User -->
    <div class="profile-card">
      <div class="profile-photo">
        <img id="profileImage"
     src="{{ $user->foto ?? asset('assets/img/default-avatar.png') }}"
     alt="User">

        <form action="{{ route('profil.update.photo') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="file" name="foto" id="uploadPhoto" accept="image/*" hidden>
          <button type="button" id="editPhotoBtn">Ubah Foto</button>
        </form>
      </div>

      <div class="profile-info">
        <form action="{{ route('profil.update') }}" method="POST">
          @csrf
          <label>Nama:</label>
          <input type="text" name="name" value="{{ $user->name }}" disabled>

          <label>Email:</label>
          <input type="email" name="email" value="{{ $user->email }}" disabled>

          <label>Nomor Telepon:</label>
          <input type="text" name="phone" value="{{ $user->phone }}" disabled>

          <button type="button" id="editBtn">Edit</button>
          <button type="submit" id="saveBtn" class="hidden">Simpan</button>

          <button type="submit" form="logoutForm" class="logout-btn">Keluar Akun</button>
        </form>
        <form id="logoutForm" action="{{ route('logout') }}" method="POST">@csrf</form>
      </div>
    </div>

    <!-- Kanan: Riwayat Reservasi -->
    <div class="history-section">
      <h2>Riwayat Reservasi</h2>
      @forelse ($bookings as $booking)
        <div class="history-item">
  <h3>
  {{ optional($booking->barber)->nama ?? '-' }}
  -
  {{ optional($booking->layanan)->nama ?? '-' }}
</h3>

  <p>Tanggal: {{ \Carbon\Carbon::parse($booking->tanggal.' '.$booking->jam)->format('d F Y H:i') }}</p>
  <p>Status: <strong>{{ $booking->status }}</strong></p>

  @if($booking->status == 'confirmed' && empty($booking->review))
    <a href="{{ route('review.create', $booking->id) }}" class="btn-review">
      ⭐ Beri Review
    </a>
  @elseif($booking->review)
    <span class="reviewed">✔ Sudah direview</span>
  @endif
</div>

      @empty
        <p>Tidak ada riwayat reservasi.</p>
      @endforelse
    </div>

  </section>

  <script>
    // Tombol edit profil
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const inputs = document.querySelectorAll('.profile-info input');

    editBtn.addEventListener('click', () => {
      inputs.forEach(i => i.disabled = false);
      editBtn.classList.add('hidden');
      saveBtn.classList.remove('hidden');
    });

    // Upload foto
    const editPhotoBtn = document.getElementById('editPhotoBtn');
    const uploadPhoto = document.getElementById('uploadPhoto');

    editPhotoBtn.addEventListener('click', () => uploadPhoto.click());
    uploadPhoto.addEventListener('change', () => uploadPhoto.form.submit());
  </script>
</body>
</html>
