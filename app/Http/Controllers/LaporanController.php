<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporan = Transaksi::with('layanan')->get();

        return view('laporan.index', compact('laporan'));
    }

    public function cetakPDF(Request $request)
    {
        $query = Transaksi::with('layanan');

        // Filter hanya berdasarkan keterangan
        if ($request->filled('keterangan')) {
            $query->where('keterangan', $request->keterangan);
        }

        $laporan = $query->get();

        $pdf = PDF::loadView('laporan.pdf', compact('laporan'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-laundry.pdf');
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
