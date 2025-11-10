<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;


// Ini Routing halaman beranda
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Ini Routing halaman layanan
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
Route::get('/layanan/create', [LayananController::class, 'create'])->name('layanan.create');
Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
Route::put('/layanan/{id}', action: [LayananController::class, 'update'])->name('layanan.update');
Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');



// Ini Routing Halaman transaksi
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::delete('/transaksi/{id}', action: [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
Route::get('/transaksi/cetak', [TransaksiController::class, 'cetakStruk'])->name('transaksi.cetak');

// Ini Routing halaman laporan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/cetak', [LaporanController::class, 'cetakPDF'])->name('laporan.cetak');



