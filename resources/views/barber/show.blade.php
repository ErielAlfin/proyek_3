<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Barber</title>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .barber-detail-container {
      max-width: 900px;
      margin: 100px auto;
      padding: 0 20px;
    }

    /* Profile Barber */
    .barber-profile {
      display: flex;
      align-items: center;
      gap: 25px;
      background: #111;
      padding: 25px;
      border-radius: 14px;
      color: #fff;
      margin-bottom: 40px;
    }

    .barber-photo {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #c59d5f;
    }

    .barber-info h1 {
      font-size: 28px;
      margin-bottom: 6px;
    }

    .barber-role {
      color: #c59d5f;
      font-size: 16px;
    }

    /* Review Section */
    .review-section h2 {
      margin-bottom: 20px;
      font-size: 24px;
      color: #222;
    }

    .review-card {
      background: #fff;
      border-radius: 12px;
      padding: 18px 20px;
      margin-bottom: 16px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    .review-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 6px;
    }

    .review-header strong {
      font-size: 15px;
    }

    .review-date {
      font-size: 13px;
      color: #777;
    }

    .review-rating {
      margin: 6px 0 10px;
      font-size: 18px;
    }

    .review-comment {
      font-style: italic;
      color: #333;
    }

    .empty-review {
      text-align: center;
      padding: 40px;
      background: #eaeaea;
      border-radius: 12px;
      color: #777;
    }

    /* Responsive */
    @media (max-width: 600px) {
      .barber-profile {
        flex-direction: column;
        text-align: center;
      }
    }
  </style>
</head>
<body>

  <div class="barber-detail-container">

    {{-- Barber Info --}}
    <div class="barber-profile">
      <img src="{{ $barber->foto }}" alt="{{ $barber->nama }}" class="barber-photo">

      <div class="barber-info">
        <h1>{{ $barber->nama }}</h1>
        <p class="barber-role">{{ $barber->spesialis }}</p>
      </div>
    </div>

    {{-- Reviews --}}
    <div class="review-section">
      <h2>Review Pelanggan</h2>

      @forelse($reviews as $review)
        <div class="review-card">
          <div class="review-header">
            <strong>{{ $review->booking->user->name ?? 'Pelanggan' }}</strong>
            <span class="review-date">
              {{ $review->created_at->format('d M Y') }}
            </span>
          </div>

          <div class="review-rating">
            @for($i = 1; $i <= 5; $i++)
              {{ $i <= $review->rating ? '⭐' : '☆' }}
            @endfor
          </div>

          <p class="review-comment">
            "{{ $review->comment }}"
          </p>
        </div>
      @empty
        <div class="empty-review">
          <p>Belum ada review untuk barber ini.</p>
        </div>
      @endforelse
    </div>

  </div>

</body>
</html>
