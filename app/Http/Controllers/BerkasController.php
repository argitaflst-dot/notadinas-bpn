<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Seksi;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;

class BerkasController extends Controller
{
    public function create()
    {
        $seksiList = Seksi::orderBy('nama_seksi')->get();

        return view('berkas.input', compact('seksiList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_seksi' => ['required', 'exists:seksi,id_seksi'],
            'id_jenis_layanan' => ['required', 'exists:jenis_layanan,id_jenis_layanan'],

            'no_berkas' => ['required', 'string', 'max:255'],
            'tanggal_pendaftaran' => ['required', 'date'],

            'no_hak' => ['nullable', 'string', 'max:255'],
            'nib_elektronik' => ['nullable', 'string', 'max:255'],

            'nama_pemohon' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],

            'nomor_akta' => ['nullable', 'string', 'max:255'],
            'tanggal_akta' => ['nullable', 'date'],
            'ppat' => ['nullable', 'string', 'max:255'],
            'desa_kelurahan' => ['nullable', 'string', 'max:255'],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'luas' => ['nullable', 'numeric'],
            'nib_elektronik_akta' => ['nullable', 'string', 'max:255'],
        ]);

        Berkas::create($validated);

        return redirect()
            ->route('berkas.create')
            ->with('success', 'Berkas berhasil disimpan.');
    }

    public function getJenisLayanan($seksi)
    {
        $jenisLayanan = JenisLayanan::where('id_seksi', $seksi)
            ->orderBy('nama_layanan')
            ->get([
                'id_jenis_layanan',
                'nama_layanan',
            ]);

        return response()->json($jenisLayanan);
    }
}