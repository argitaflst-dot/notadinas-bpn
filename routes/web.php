<?php

use App\Http\Controllers\BerkasController;
use App\Http\Controllers\NotaDinasController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('berkas.create');
});

Route::get('/input-berkas', [BerkasController::class, 'create'])
    ->name('berkas.create');

Route::post('/input-berkas', [BerkasController::class, 'store'])
    ->name('berkas.store');

Route::get('/berkas/{id}/edit', [BerkasController::class, 'edit'])
    ->name('berkas.edit');

Route::put('/berkas/{id}', [BerkasController::class, 'update'])
    ->name('berkas.update');

Route::get('/jenis-layanan/{seksi}', [BerkasController::class, 'getJenisLayanan'])
    ->name('jenis-layanan.by-seksi');

// Pilih Berkas
Route::get('/pilih-berkas', [BerkasController::class, 'pilih'])->name('berkas.pilih');
Route::post('/cetak-nota-dinas', [NotaDinasController::class, 'store'])->name('nota-dinas.store');

// Riwayat Nota Dinas
Route::get('/riwayat-nota-dinas', [RiwayatController::class, 'index'])
    ->name('berkas.riwayat');

Route::get('/nota-dinas/{notaDinas}/preview',
    [NotaDinasController::class, 'preview']
)->name('nota-dinas.preview');
Route::post(
    '/nota-dinas/{notaDinas}/cetak',
    [NotaDinasController::class, 'cetak']
)->name('nota-dinas.cetak');
Route::get(
    '/nota-dinas/{notaDinas}/pdf',
    [NotaDinasController::class, 'cetak']
)->name('nota-dinas.pdf');
Route::post(
    '/nota-dinas/{notaDinas}/finalisasi',
    [NotaDinasController::class, 'finalisasi']
)->name('nota-dinas.finalisasi');

Route::get('/riwayat', [RiwayatController::class, 'index'])
    ->name('berkas.riwayat');
