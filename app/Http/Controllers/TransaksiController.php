<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Layanan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('layanan')->get();
        $layanan = Layanan::all();
        return view('transaksi.index', compact('transaksi', 'layanan'));
    }

    public function create()
    {
        return redirect()->route('transaksi.index');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'id_layanan' => 'required|exists:layanan,id_layanan',
            'berat' => 'required|numeric',
            'nama_pelanggan' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        Transaksi::create($validated);

        return redirect()->route('transaksi.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(Transaksi $transaksi)
    {
        return redirect()->route('transaksi.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'id_layanan' => 'required|exists:layanan,id_layanan',
            'berat' => 'required|numeric',
            'nama_pelanggan' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
