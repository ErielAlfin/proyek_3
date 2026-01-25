<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Cloudinary;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->get();
        return view('booking', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barber_id' => 'required',
            'layanan_id' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'harga' => 'required|numeric',
        ]);

        $booking = Booking::create([
    'user_id' => auth()->id(),
    'barber_id' => $request->barber_id,
    'layanan_id' => $request->layanan_id,
    'tanggal' => $request->tanggal,
    'jam' => $request->jam,
    'harga' => $request->harga,
    'status' => 'pending',
]);


        return redirect()->route('booking.payment.show', $booking->id);
    }

    public function showPayment(Booking $booking)
{
    if ($booking->user_id !== auth()->id()) {
        abort(403);
    }

    $booking->load(['barber', 'layanan']);

    return view('booking.payment', compact('booking'));
}



    public function uploadPayment(Request $request, Booking $booking)
{
    // Pastikan hanya user pemilik booking yang bisa upload
    if ($booking->user_id !== auth()->id()) {
        abort(403);
    }

    // Validasi file
    $request->validate([
        'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('bukti_transfer')) {
    try {
        $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
        $filePath = $request->file('bukti_transfer')->getPathname();
        $upload = $cloudinary->uploadApi()->upload($filePath, ['folder' => 'bukti_transfer']);
        $booking->bukti_pembayaran = $upload['secure_url'];
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal upload ke Cloudinary: ' . $e->getMessage());
    }
}



    // Update status booking
    $booking->metode_pembayaran = 'qris';
    $booking->status = 'waiting';
    $booking->save();

    // Redirect ke profil user
    return redirect()
        ->route('profil.index')
        ->with('success', 'Bukti pembayaran berhasil dikirim');
}


    public function clearHistory()
{
    // Hanya hapus booking milik user yang sedang login
    Booking::where('user_id', auth()->id())->delete();  

    return back()->with('success', 'Riwayat reservasi berhasil dikosongkan.');
}

}
