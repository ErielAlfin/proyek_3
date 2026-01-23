<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Booking;

class ReviewController extends Controller
{
    public function create(Booking $booking)
    {
        // proteksi: hanya booking confirmed
        if ($booking->status !== 'confirmed') {
            abort(403);
        }

        return view('review.create', compact('booking'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        Review::create([
            'booking_id' => $booking->id,
            'barber_id'  => $booking->barber_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return redirect()->route('profil.index')
            ->with('success', 'Review berhasil dikirim');
    }
}
