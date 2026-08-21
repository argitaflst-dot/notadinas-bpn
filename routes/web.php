<?php

use App\Http\Controllers\BerkasController;
use App\Http\Controllers\NotaDinasController;
use Illuminate\Support\Facades\Route;

// Halaman utama tidak perlu diberi nama jika fungsinya hanya mengalihkan/menampilkan hal yang sama
Route::get('/', [BerkasController::class, 'create']);

Route::get('/input-berkas', [BerkasController::class, 'create'])
    ->name('berkas.create');

Route::post('/input-berkas', [BerkasController::class, 'store'])
    ->name('berkas.store');

Route::get('/berkas/{id}/edit', [BerkasController::class, 'edit'])
    ->name('berkas.edit');

Route::put('/berkas/{id}', [BerkasController::class, 'update'])
    ->name('berkas.update');

// Endpoint AJAX untuk cascading dropdown
Route::get('/jenis-layanan/{seksi}', [BerkasController::class, 'getJenisLayanan'])
    ->name('jenis-layanan.by-seksi');

// Pilih Berkas
Route::get('/pilih-berkas', [BerkasController::class, 'pilih'])->name('berkas.pilih');
Route::post('/cetak-nota-dinas', [NotaDinasController::class, 'store'])->name('nota-dinas.store');

// Nanti kita tambahkan route lain di sini