<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['booking.user', 'barber'])
            ->latest()
            ->get();

        return view('admin.reviews.index', compact('reviews'));
    }
}
