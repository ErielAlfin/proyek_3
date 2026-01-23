<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Beri Review</title>
  <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
</head>
<body>

<nav class="navbar">
  <div class="logo">Barbershop Klasik</div>
  <a href="{{ route('profil.index') }}" class="btn-kembali">Kembali</a>
</nav>

<section class="review-page">
  <div class="review-card">
    <h2>Beri Review</h2>
    <p class="subtitle">Bagikan pengalaman kamu setelah layanan kami</p>

    <form action="{{ route('review.store') }}" method="POST">
      @csrf
      <input type="hidden" name="booking_id" value="{{ $booking->id }}">

      <label>Rating</label>
      <select name="rating" required>
        <option value="">Pilih Rating</option>
        <option value="5">⭐⭐⭐⭐⭐ Sangat Puas</option>
        <option value="4">⭐⭐⭐⭐ Puas</option>
        <option value="3">⭐⭐⭐ Cukup</option>
        <option value="2">⭐⭐ Kurang</option>
        <option value="1">⭐ Buruk</option>
      </select>

      <label>Komentar</label>
      <textarea name="comment" rows="4" required placeholder="Ceritakan pengalaman kamu..."></textarea>

      <button type="submit" class="btn-review">Kirim Review</button>
    </form>
  </div>
</section>

</body>
</html>
