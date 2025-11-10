<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::all();
        return view('layanan.index', compact('layanan'));
    }

    public function create()
    {
        return view('layanan.create');
    }

    public function store(Request $request)
    {
        Layanan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ]);

        return redirect()->route('layanan.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('layanan.edit', compact('layanan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        $layanan = Layanan::findOrFail($id);
        $layanan->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Layanan berhasil diperbarui!'
        ]);
    }




    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return response()->json(['success' => true]);
    }
}
