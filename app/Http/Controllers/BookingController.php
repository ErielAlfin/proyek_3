<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Layanan;
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

    // ambil durasi layanan
    $layanan = Layanan::findOrFail($request->layanan_id);
    $durasi = $layanan->durasi;

    $startRequest = Carbon::parse($request->tanggal.' '.$request->jam);
    $endRequest   = $startRequest->copy()->addMinutes($durasi);

    // ambil booking barber di tanggal tersebut
    $bookings = Booking::where('barber_id', $request->barber_id)
        ->where('tanggal', $request->tanggal)
        ->get();

    foreach ($bookings as $booking) {
        $bookingStart = Carbon::parse($booking->tanggal.' '.$booking->jam);
        $bookingEnd   = $bookingStart->copy()->addMinutes($booking->durasi);

        // CEK TABRAKAN WAKTU
        if ($startRequest < $bookingEnd && $endRequest > $bookingStart) {
            return back()->with('error', 'Jam sudah dibooking, silakan pilih jam lain.');
        }
    }

    // BARU CREATE
    $booking = Booking::create([
        'user_id' => auth()->id(),
        'barber_id' => $request->barber_id,
        'layanan_id' => $request->layanan_id,
        'tanggal' => $request->tanggal,
        'jam' => $request->jam,
        'durasi' => $durasi,
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
    if ($booking->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'bukti_transfer_url' => 'required|url',
    ]);

    $booking->update([
        'bukti_pembayaran' => $request->bukti_transfer_url,
        'metode_pembayaran' => 'qris',   // pastikan ENUM / VARCHAR cocok
        'status' => 'pending',           // HARUS ADA DI ENUM
    ]);

    return response()->json(['success' => true]);
}





    public function clearHistory()
{
    // Hanya hapus booking milik user yang sedang login
    Booking::where('user_id', auth()->id())->delete();  

    return back()->with('success', 'Riwayat reservasi berhasil dikosongkan.');
}

public function availableTimes(Request $request)
{
    $barberId = $request->barber_id;
    $tanggal = $request->tanggal;
    $layanan = Layanan::findOrFail($request->layanan_id);

    $durasi = $layanan->durasi;

    // jam kerja
    $start = Carbon::createFromTime(9, 0);
    $end   = Carbon::createFromTime(18, 0);

    // ambil booking barber di tanggal itu
    $bookings = Booking::where('barber_id', $barberId)
        ->where('tanggal', $tanggal)
        ->get();

    $available = [];

    while ($start->copy()->addMinutes($durasi) <= $end) {
        $slotStart = $start->copy();
        $slotEnd   = $start->copy()->addMinutes($durasi);

        $conflict = false;

        foreach ($bookings as $booking) {
            $bookingStart = Carbon::parse($booking->tanggal.' '.$booking->jam);
            $bookingEnd   = $bookingStart->copy()->addMinutes($booking->durasi);

            if ($slotStart < $bookingEnd && $slotEnd > $bookingStart) {
                $conflict = true;
                break;
            }
        }

        if (!$conflict) {
            $available[] = $slotStart->format('H:i');
        }

        $start->addMinutes(30); // interval 30 menit
    }

    return response()->json($available);
}

}
