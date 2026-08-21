<?php

namespace App\Http\Controllers;

use App\Models\NotaDinas;
use App\Models\Berkas;
use Illuminate\Http\Request;

class NotaDinasController extends Controller
{
    public function store(Request $request)
    {
        return back()->withErrors([
            'nota_dinas' => 'Halaman pembuatan Nota Dinas belum tersedia.',
        ]);

        $validated = $request->validate([
            'berkas_id' => ['required', 'array', 'min:1'],
            'berkas_id.*' => ['exists:berkas,id'],
        ]);

        $berkasTerpilih = Berkas::whereIn('id', $validated['berkas_id'])
            ->where('status', '!=', 'sudah_nota_dinas')
            ->get();
        
        if ($berkasTerpilih->count() !== count($validated['berkas_id'])) {
            return back()->withErrors('Ada berkas yang sudah masuk nota dinas lain, tidak bisa dipilih ulang.');
        }

        $notaDinas = NotaDinas::create([
            'nomor'   => (int) NotaDinas::max('nomor') + 1,
            'tahun'   => now()->year,
            'kepada'  => null, 
            'dari'    => null, 
            'tanggal' => now(),
            'status'  => 'draft',
        ]);

        $notaDinas->berkas()->attach($berkasTerpilih->pluck('id'));

        Berkas::whereIn('id', $berkasTerpilih->pluck('id'))
            ->update(['status' => 'sudah_nota_dinas']);

        return redirect()->route('berkas.pilih')
            ->with('success', 'Nota dinas berhasil dibuat.');
    }
}