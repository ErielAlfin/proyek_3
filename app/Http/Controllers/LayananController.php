<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan; // pastikan model Layanan ada

class LayananController extends Controller
{
    // Tampilkan semua layanan
    public function index()
    {
        $layanan = Layanan::all();
        return view('admin.layanan.index', compact('layanan'));
    }

    // Tampilkan form tambah layanan
    public function create()
    {
        return view('admin.layanan.create');
    }

    // Simpan layanan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
        ]);

        Layanan::create($request->all());

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan berhasil ditambahkan');
    }

    // Edit layanan
    public function edit($id)
{
    $layanan = Layanan::findOrFail($id);
    return view('admin.layanan.edit', compact('layanan'));
}


    // Update layanan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
        ]);

        $layanan = Layanan::findOrFail($id);
        $layanan->update($request->all());

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan berhasil diupdate');
    }

    // Hapus layanan
    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan berhasil dihapus');
    }
}
