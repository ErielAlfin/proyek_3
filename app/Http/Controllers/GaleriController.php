<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::all();
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

     public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $galeri = new Galeri();
        $galeri->judul = $request->judul;
        $galeri->deskripsi = $request->deskripsi;

        if ($request->hasFile('foto')) {
            $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
            $upload = $cloudinary->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'galeri']
            );

            $galeri->foto = $upload['secure_url']; // simpan URL Cloudinary
        }

        $galeri->save();

        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($request->hasFile('foto')) {
            $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
            $upload = $cloudinary->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'galeri']
            );
            $galeri->foto = $upload['secure_url'];
        }

        $galeri->judul = $request->judul;
        $galeri->deskripsi = $request->deskripsi;
        $galeri->save();

        return redirect()->route('admin.galeri.index')->with('success', 'Data diperbarui!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil dihapus!');
    }
}
