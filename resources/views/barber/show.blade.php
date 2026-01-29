<h1>{{ $barber->nama }}</h1>
<p>{{ $barber->spesialis }}</p>

<hr>

<h2>Review Pelanggan</h2>

@forelse($reviews as $review)
  <div class="review-card">
    <strong>{{ $review->booking->user->name ?? 'Pelanggan' }}</strong>

    <div class="review-rating">
      @for($i = 1; $i <= 5; $i++)
        {{ $i <= $review->rating ? '⭐' : '☆' }}
      @endfor
    </div>

    <p>"{{ $review->comment }}"</p>
  </div>
@empty
  <p>Belum ada review untuk barber ini.</p>
@endforelse
