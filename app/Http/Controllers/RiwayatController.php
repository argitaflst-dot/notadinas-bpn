<?php

namespace App\Http\Controllers;

use App\Models\NotaDinas;
use App\Models\Seksi;

class RiwayatController extends Controller
{
    public function index()
    {
        $notaDinasList = NotaDinas::where('status', 'final')
            ->with(['berkas.seksi'])
            ->withCount('berkas')
            ->orderByDesc('tanggal')
            ->get();

        $seksiList = Seksi::orderBy('nama_seksi')->get();

        return view('nota-dinas.riwayat', compact(
            'notaDinasList',
            'seksiList'
        ));
    }
}
