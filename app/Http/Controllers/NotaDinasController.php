<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\NotaDinas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaDinasController extends Controller
{
    
public function store(Request $request)
{
    $validated = $request->validate([
        'berkas_id' => ['required', 'array', 'min:1'],
        'berkas_id.*' => ['required', 'exists:berkas,id_berkas'],
    ]);

    // Normalisasi ID agar perbandingan konsisten
    $idDipilih = collect($validated['berkas_id'])
        ->map(fn ($id) => (int) $id)
        ->unique()
        ->sort()
        ->values()
        ->all();

    $berkasTerpilih = Berkas::with([
        'seksi',
        'jenisLayanan',
    ])
        ->whereIn('id_berkas', $idDipilih)
        ->get();

    $berkasSudahFinal = $berkasTerpilih->where(
        'status',
        'sudah_nota_dinas'
    );

    if ($berkasSudahFinal->isNotEmpty()) {
        return back()->withErrors([
            'berkas_id' =>
                'Ada berkas yang sudah menjadi Nota Dinas dan tidak dapat dipilih kembali.',
        ]);
    }

    $idSeksi = $berkasTerpilih
        ->pluck('id_seksi')
        ->filter()
        ->unique();

    if ($idSeksi->count() !== 1) {
        return back()->withErrors([
            'berkas_id' =>
                'Berkas yang dipilih harus berasal dari seksi yang sama.',
        ]);
    }

    $seksi = $berkasTerpilih->first()->seksi;

    if (! $seksi) {
        return back()->withErrors([
            'berkas_id' =>
                'Data seksi pada berkas tidak ditemukan.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Cek draft dengan kumpulan berkas yang sama
    |--------------------------------------------------------------------------
    */

    $draftLama = NotaDinas::where('tahun', now()->year)
        ->where('status', 'draft')
        ->with('berkas')
        ->get()
        ->first(function ($draft) use ($idDipilih) {

            $idDraft = $draft->berkas
                ->pluck('id_berkas')
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->sort()
                ->values()
                ->all();

            return $idDraft === $idDipilih;
        });

    // Jika draft sudah ada, gunakan draft lama
    if ($draftLama) {
        return redirect()->route(
            'nota-dinas.preview',
            [
                'notaDinas' => $draftLama->getKey(),
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Buat nomor baru
    |--------------------------------------------------------------------------
    */

    $tahunSekarang = now()->year;
    $jabatan = 'KKS ' . $seksi->nama_seksi;

    $notaDinas = DB::transaction(function () use (
        $tahunSekarang,
        $berkasTerpilih,
        $jabatan
    ) {

        $nomorTerakhir = NotaDinas::where(
            'tahun',
            $tahunSekarang
        )
            ->lockForUpdate()
            ->max(DB::raw('CAST(nomor AS UNSIGNED)'));

        $nomorBaru = ($nomorTerakhir ?? 0) + 1;

        $nota = NotaDinas::create([
            'nomor' => $nomorBaru,
            'tahun' => $tahunSekarang,
            'kepada' =>
                'Kepala Seksi Penetapan Hak dan Pendaftaran',
            'dari' => $jabatan,
            'tanggal' => now(),
            'status' => 'draft',
        ]);

        $nota->berkas()->attach(
            $berkasTerpilih
                ->pluck('id_berkas')
                ->toArray()
        );

        return $nota;
    });

    return redirect()->route(
        'nota-dinas.preview',
        [
            'notaDinas' => $notaDinas->getKey(),
        ]
    );
}

    public function preview(NotaDinas $notaDinas)
    {

        $notaDinas->load([
            'berkas.seksi',
            'berkas.jenisLayanan',
        ]);

        $seksi = $notaDinas
            ->berkas
            ->first()
            ?->seksi;

        if (! $seksi) {
            return redirect()
                ->route('berkas.pilih')
                ->withErrors([
                    'berkas_id' => 'Seksi dari Nota Dinas tidak ditemukan.',
                ]);
        }

        $jabatanKoordinator =
            'KKS '.$seksi->nama_seksi;

        return view(
            'nota-dinas.preview',
            compact(
                'notaDinas',
                'seksi',
                'jabatanKoordinator'
            )
        );
    }

    public function cetak(Request $request, NotaDinas $notaDinas)
    {

        $notaDinas->load([
            'berkas.seksi',
            'berkas.jenisLayanan',
        ]);

        $seksi = $notaDinas
            ->berkas
            ->first()
            ?->seksi;

        if (! $seksi) {
            return redirect()
                ->route('berkas.pilih')
                ->withErrors([
                    'berkas_id' => 'Seksi dari Nota Dinas tidak ditemukan.',
                ]);
        }

        $jabatanKoordinator =
            'KKS '.$seksi->nama_seksi;

        $pdf = Pdf::loadView(
            'nota-dinas.pdf',
            compact(
                'notaDinas',
                'seksi',
                'jabatanKoordinator'
            )
        );

        $pdf->setPaper('a4', 'landscape');

        $namaFile =
            'Nota-Dinas-No-'.
            $notaDinas->nomor.
            '-Tahun-'.
            $notaDinas->tahun.
            '.pdf';

        return $pdf->stream($namaFile);
    }

    public function finalisasi(
        Request $request,
        NotaDinas $notaDinas
    ) {

        if ($notaDinas->status === 'final') {
            return redirect()
                ->route('berkas.pilih')
                ->with(
                    'success',
                    'Nota Dinas sudah final.'
                );
        }

        DB::transaction(function () use ($notaDinas) {

            $notaDinas->berkas()->update([
                'status' => 'sudah_nota_dinas',
            ]);

            $notaDinas->update([
                'status' => 'final',
            ]);
        });

        return redirect()
            ->route('berkas.pilih')
            ->with(
                'success',
                'Nota Dinas No. '.
                $notaDinas->nomor.
                ' Tahun '.
                $notaDinas->tahun.
                ' berhasil difinalkan.'
            );
    }

    public function riwayat()
{
    $notaDinasList = NotaDinas::with([
        'berkas.seksi',
        'berkas.jenisLayanan',
    ])
        ->withCount('berkas')
        ->where('status', 'final')
        ->orderByDesc('tahun')
        ->orderByDesc('nomor')
        ->get();

    $seksiList = \App\Models\Seksi::orderBy('nama_seksi')->get();

    return view('nota-dinas.riwayat', compact(
        'notaDinasList',
        'seksiList'
    ));
}
}
