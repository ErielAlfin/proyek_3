<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbershop Klasik - Potong Rambut Pria Profesional</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('vite.svg') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  </head>
  <body>
    {{-- Navbar --}}
    <nav class="navbar">
      <div class="nav-container">
        <div class="logo">Barbershop Klasik</div>
        <ul class="nav-menu">
          <li><a href="#home">Beranda</a></li>
          <li><a href="#services">Layanan</a></li>
          <li><a href="#barbers">Barbers</a></li>
          <li><a href="#gallery">Galeri</a></li>
          <li><a href="{{ url('booking') }}">Booking</a></li>
          <li><a href="#contact">Kontak</a></li>
          <li>
            <a href="{{ url('profil') }}">
              <img src="{{ asset('assets/img/user.png') }}" 
                   alt="Profil" style="width:28px; height:28px; border-radius:50%;">
            </a>
          </li>
        </ul>
        <div class="hamburger">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </nav>

    {{-- Hero Section --}}
    <section id="home" class="hero">
      <div class="hero-content">
        <h1>Selamat Datang di Barbershop Klasik</h1>
        <p>Gaya Rambut Terbaik untuk Pria Modern</p>
        <a href="{{ url('booking') }}" class="btn-primary">Booking Sekarang</a>
      </div>
    </section>

    {{-- Services --}}
    <section id="services" class="services">
  <div class="container">
    <h2 class="section-title">Layanan Kami</h2>
    <div class="services-grid">
      @foreach($layanans as $layanan)
        <div class="service-card">
          <div class="service-icon">💈</div>
          <h3>{{ $layanan->nama }}</h3>
          <p>{{ $layanan->deskripsi }}</p>
          <span class="price">Rp {{ number_format($layanan->harga,0,',','.') }}</span>
        </div>
      @endforeach
    </div>
  </div>
</section>




    {{-- Barber --}}
    <section id="barbers" class="barber-section">
  <div class="container">
    <h2 class="section-title">Barber Profesional Kami</h2>
    <div class="barber-grid">
      @foreach($barbers as $barber)
        <div class="barber-card">
          <img src="{{ $barber->foto }}" alt="{{ $barber->nama }}">
          <h3>{{ $barber->nama }}</h3>
          <p>{{ $barber->spesialis }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>




    {{-- Gallery --}}
    <section id="gallery" class="gallery">
  <div class="container">
    <h2 class="section-title">Galeri</h2>
    <div class="gallery-grid">
      @foreach($galleries as $gallery)
        <div class="gallery-item">
          <img src="{{ $gallery->foto }}">
          <h3>{{ $gallery->judul }}</h3>
  <p>{{ $gallery->deskripsi }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>



{{-- Reviews --}}
<section id="reviews" class="reviews">
  <div class="container">

    <div class="reviews-wrapper">
      <h2 class="section-title">Apa Kata Pelanggan Kami</h2>

      <div class="review-grid">
        @forelse($reviews as $review)
          <div class="review-card">

            <div class="review-header">
              <strong>{{ $review->booking->user->name ?? 'Pelanggan' }}</strong>
              <span class="review-date">
                {{ $review->created_at->format('d M Y') }}
              </span>
            </div>

            <p class="review-barber">
              Barber: {{ $review->barber->nama ?? '-' }}
            </p>

            <div class="review-rating">
              @for ($i = 1; $i <= 5; $i++)
                {{ $i <= $review->rating ? '⭐' : '☆' }}
              @endfor
            </div>

            <p class="review-comment">
              "{{ $review->comment }}"
            </p>

          </div>
        @empty
          <p class="text-center">Belum ada review.</p>
        @endforelse
      </div>
    </div>

  </div>
</section>




    {{-- Contact --}}
    <section id="contact" class="contact">
      <div class="container">
        <h2 class="section-title">Hubungi Kami</h2>
        <div class="contact-grid">
          <div class="contact-item">
            <div class="contact-icon">📍</div>
            <h3>Alamat</h3>
            <p>Jl. Asem 2 No. 123<br>Jakarta Selatan, 11530</p>
          </div>
          <div class="contact-item">
            <div class="contact-icon">📞</div>
            <h3>Telepon</h3>
            <p>(021) 1234-5678<br>0812-3456-7890</p>
          </div>
          <div class="contact-item">
            <div class="contact-icon">⏰</div>
            <h3>Jam Operasional</h3>
            <p>Senin - Sabtu: 09:00 - 20:00<br>Minggu: 10:00 - 18:00</p>
          </div>
        </div>
      </div>
    </section>

    {{-- Footer --}}
    <footer class="footer">
      <div class="container">
        <p>&copy; 2025 Barbershop Klasik. All rights reserved.</p>
      </div>
    </footer>

    <script src="{{ asset('assets/js/main.js') }}"></script>
  </body>
</html>
