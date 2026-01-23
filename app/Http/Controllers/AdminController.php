<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class AdminController extends Controller
{
    public function index()
{
    // Total Booking
    $totalOrder = Booking::count();

    // Total Reservasi (booking yang sudah ada waktu_booking)
    $totalReservasi = Booking::whereNotNull('waktu_booking')->count();

    // Pending
    $pending = Booking::where('status', 'pending')->count();

    // Total Income → sum harga layanan
    $totalIncome = Booking::with('layanan')->get()->sum(function ($b) {
        return $b->layanan->harga ?? 0;
    });

    // Semua order terbaru, tanpa limit, termasuk unpaid
    $orders = Booking::with(['user', 'layanan'])->latest()->get();

    return view('admin.admin', compact(
        'totalOrder',
        'totalIncome',
        'totalReservasi',
        'pending',
        'orders'
    ));
}


public function confirm($id)
{
    $booking = Booking::findOrFail($id);
    $booking->payment_status = 'paid';
    $booking->status = 'confirmed'; // tambahkan ini
    $booking->save();

    return back()->with('success', 'Pembayaran dikonfirmasi.');
}


public function reject($id)
{
    $booking = Booking::findOrFail($id);
    $booking->status = 'cancel'; 
    $booking->payment_status = 'unpaid';
    $booking->bukti_pembayaran = null;
    $booking->save();

    return back()->with('success', 'Booking ditolak.');
}

public function clearAllBookings()
{
    Booking::query()->delete(); // ✅ BENAR
    return back()->with('success', 'Semua booking berhasil dikosongkan.');
}


}
