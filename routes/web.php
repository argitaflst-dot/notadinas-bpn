<?php

use App\Http\Controllers\BerkasController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BerkasController::class, 'create'])->name('berkas.create');

Route::get('/input-berkas', [BerkasController::class, 'create'])
    ->name('berkas.create');

Route::post('/input-berkas', [BerkasController::class, 'store'])
    ->name('berkas.store');

// Endpoint AJAX untuk cascading dropdown
Route::get('/jenis-layanan/{seksi}', [BerkasController::class, 'getJenisLayanan'])
    ->name('jenis-layanan.by-seksi');

// Nanti kita tambahkan route lain di sini