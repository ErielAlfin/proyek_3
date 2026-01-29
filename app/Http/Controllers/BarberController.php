<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barber;
use App\Models\Review;
use Cloudinary\Cloudinary;


class BarberController extends Controller
{
    // TAMPIL SEMUA BARBER
    public function index()
    {
        $barbers = Barber::all();
        return view('admin.barber.index', compact('barbers'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('admin.barber.create');
    }

    // SIMPAN BARBER
    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'spesialis' => 'required',
        'telepon' => 'nullable',
        'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $barber = new Barber();
    $barber->nama = $request->nama;
    $barber->spesialis = $request->spesialis;
    $barber->telepon = $request->telepon;

    if ($request->hasFile('foto')) {
        $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
        $upload = $cloudinary->uploadApi()->upload(
            $request->file('foto')->getRealPath(),
            ['folder' => 'barbers']
        );

        $barber->foto = $upload['secure_url']; // simpan URL Cloudinary
    }

    $barber->save();

    return redirect()->route('admin.barber.index')
                     ->with('success', 'Barber berhasil ditambahkan!');
}




    // FORM EDIT
    public function edit($id)
    {
        $barber = Barber::findOrFail($id);
        return view('admin.barber.edit', compact('barber'));
    }

    // UPDATE BARBER
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'spesialis' => 'required',
            'telepon' => 'nullable',
            'foto' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $barber = Barber::findOrFail($id);
        $barber->nama = $request->nama;
        $barber->spesialis = $request->spesialis;
        $barber->telepon = $request->telepon;

        if ($request->hasFile('foto')) {
    $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
    $upload = $cloudinary->uploadApi()->upload(
        $request->file('foto')->getRealPath(),
        ['folder' => 'barbers']
    );
    $barber->foto = $upload['secure_url'];
}



        $barber->save();

        return redirect()->route('admin.barber.index')->with('success', 'Barber berhasil diperbarui!');
    }

    // HAPUS
    public function destroy($id)
    {
        $barber = Barber::findOrFail($id);
        $barber->delete();

        return redirect()->route('admin.barber.index')->with('success', 'Barber berhasil dihapus!');
    }
    
    public function show($id)
{
    $barber = Barber::findOrFail($id);

    $reviews = Review::where('barber_id', $id)
        ->with('booking.user')
        ->latest()
        ->get();

    return view('barber.show', compact('barber', 'reviews'));
}


}
