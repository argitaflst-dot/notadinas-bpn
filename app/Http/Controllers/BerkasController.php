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
        $validated = $this->validateBerkas($request);

        // Cek apakah nomor berkas sudah digunakan
        if (Berkas::where('no_berkas', $validated['no_berkas'])->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'no_berkas' => 'Nomor berkas ' . $validated['no_berkas'] . ' sudah terdaftar. Silakan gunakan nomor berkas lain.'
                ]);
        }

        $jenisLayanan = JenisLayanan::whereKey($validated['id_jenis_layanan'])
            ->where('id_seksi', $validated['id_seksi'])
            ->firstOrFail();

        Berkas::create(
            $this->berkasAttributes($validated, $jenisLayanan)
        );

        return redirect()
            ->route('berkas.create')
            ->with('success', 'Berkas berhasil disimpan.');
    }

    public function edit($id)
    {
        $berkas = Berkas::with('jenisLayanan.seksi')
            ->findOrFail($id);

        if ($berkas->status === 'sudah_nota_dinas') {
            abort(403, 'Berkas yang sudah final tidak dapat diedit.');
        }

        $seksiList = Seksi::orderBy('nama_seksi')->get();

        return view(
            'berkas.edit',
            compact('berkas', 'seksiList')
        );
    }

    public function update(Request $request, $id)
    {
        $berkas = Berkas::findOrFail($id);

        if ($berkas->status === 'sudah_nota_dinas') {
            abort(403, 'Berkas yang sudah final tidak dapat diedit.');
        }

        $validated = $this->validateBerkas($request);

        $berkas->update([
            'id_seksi' => $validated['id_seksi'],
            'id_jenis_layanan' => $validated['id_jenis_layanan'],
            'no_berkas' => $validated['no_berkas'],
            'tanggal_pendaftaran' => $validated['tanggal_pendaftaran'],
            'no_hak' => $validated['no_hak'] ?? null,
            'nib_elektronik' => $validated['nib_elektronik'] ?? null,
            'nama_pemohon' => $validated['nama_pemohon'],
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'nomor_akta' => $validated['nomor_akta'] ?? null,
            'tanggal_akta' => $validated['tanggal_akta'] ?? null,
            'ppat' => $validated['ppat'] ?? null,
            'desa_kelurahan' => $validated['desa_kelurahan'] ?? null,
            'kecamatan' => $validated['kecamatan'] ?? null,
            'luas' => $validated['luas'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()
            ->route('berkas.pilih')
            ->with('success', 'Berkas berhasil diperbarui.');
    }

    private function validateBerkas(Request $request): array
    {
        return $request->validate([
            'id_seksi' => [
                'required',
                'exists:seksi,id_seksi'
            ],

            'id_jenis_layanan' => [
                'required',
                'exists:jenis_layanan,id_jenis_layanan'
            ],

            'no_berkas' => [
                'required',
                'string',
                'max:255'
            ],

            'tanggal_pendaftaran' => [
                'required',
                'date'
            ],

            'no_hak' => [
                'nullable',
                'string',
                'max:255'
            ],

            'nib_elektronik' => [
                'nullable',
                'string',
                'max:255'
            ],

            'nama_pemohon' => [
                'required',
                'string',
                'max:255'
            ],

            'tempat_lahir' => [
                'nullable',
                'string',
                'max:255'
            ],

            'tanggal_lahir' => [
                'nullable',
                'date'
            ],

            'nomor_akta' => [
                'nullable',
                'string',
                'max:255'
            ],

            'tanggal_akta' => [
                'nullable',
                'date'
            ],

            'ppat' => [
                'nullable',
                'string',
                'max:255'
            ],

            'desa_kelurahan' => [
                'nullable',
                'string',
                'max:255'
            ],

            'kecamatan' => [
                'nullable',
                'string',
                'max:255'
            ],

            'luas' => [
                'nullable',
                'numeric'
            ],

            'keterangan' => [
                'nullable',
                'string'
            ],
        ]);
    }

    private function berkasAttributes(
        array $validated,
        JenisLayanan $jenisLayanan
    ): array {
        return [
            'id_seksi' => $validated['id_seksi'],

            'id_jenis_layanan' => $validated['id_jenis_layanan'],

            'no_berkas' => $validated['no_berkas'],

            'tanggal_pendaftaran' => $validated['tanggal_pendaftaran'],

            'no_hak' => $validated['no_hak'] ?? null,

            'nib_elektronik' => $validated['nib_elektronik'] ?? null,

            'nama_pemohon' => $validated['nama_pemohon'],

            'tempat_lahir' => $validated['tempat_lahir'] ?? null,

            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,

            'nomor_akta' => $validated['nomor_akta'] ?? null,

            'tanggal_akta' => $validated['tanggal_akta'] ?? null,

            'ppat' => $validated['ppat'] ?? null,

            'desa_kelurahan' => $validated['desa_kelurahan'] ?? null,

            'kecamatan' => $validated['kecamatan'] ?? null,

            'luas' => $validated['luas'] ?? null,

            'keterangan' => $validated['keterangan'] ?? null,
        ];
    }

    public function getJenisLayanan($seksi)
    {
        $jenisLayanan = JenisLayanan::where(
            'id_seksi',
            $seksi
        )
        ->orderBy('nama_layanan')
        ->get([
            'id_jenis_layanan',
            'nama_layanan',
        ]);

        return response()->json($jenisLayanan);
    }

    public function pilih()
    {
        $berkasList = Berkas::with('jenisLayanan.seksi')
            ->orderByDesc('tanggal_pendaftaran')
            ->get();

        return view(
            'berkas.pilih',
            compact('berkasList')
        );
    }
}