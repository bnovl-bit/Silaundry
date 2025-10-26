<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class BerandaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $beranda = Transaksi::join('layanan', 'transaksi.id_layanan', '=', 'layanan.id_layanan')
        ->select(
            'transaksi.created_at as tanggal',
            'layanan.nama as layanan',
            'transaksi.berat',
            'transaksi.nama_pelanggan',
            'transaksi.keterangan'
        )
        ->whereDate('transaksi.created_at', now()) 
        ->orderBy('transaksi.created_at', 'desc')
        ->get();
        $layanan = Layanan::count();
        $transaksi = Transaksi::whereNotNull('id_transaksi')->count();
        $pendapatan = Transaksi::join('layanan', 'transaksi.id_layanan', '=', 'layanan.id_layanan')
            ->whereDate('transaksi.created_at', now())
            ->sum(DB::raw('transaksi.berat * layanan.harga'));

        $belumDiambil = Transaksi::whereIn('keterangan', ['proses', 'siap diambil'])->count();

        return view("beranda", compact(
            'beranda',
            'layanan',
            'transaksi',
            'pendapatan',
            'belumDiambil',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
