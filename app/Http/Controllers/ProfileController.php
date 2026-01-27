<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;
use Cloudinary\Cloudinary;

class ProfileController extends Controller
{
    public function index()
{
    $user = Auth::user();

    $bookings = Booking::where('user_id', $user->id)
        ->with(['barber', 'layanan'])
        ->orderBy('tanggal', 'desc')
->orderBy('jam', 'desc')

        ->get();

    return view('profile', compact('user', 'bookings'));
}


    public function updatePhoto(Request $request)
{
    $request->validate([
        'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user = Auth::user();

    $cloudinary = new Cloudinary();

    $upload = $cloudinary->uploadApi()->upload(
        $request->file('foto')->getRealPath(),
        [
            'folder' => 'profile_photos',
        ]
    );

    // SIMPAN URL, BUKAN PATH
    $user->foto = $upload['secure_url'];
    $user->save();

    return back()->with('success', 'Foto profil berhasil diperbarui!');
}

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only('name', 'email', 'phone'));

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
