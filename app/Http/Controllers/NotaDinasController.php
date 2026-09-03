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

        $berkasTerpilih = Berkas::with([
            'seksi',
            'jenisLayanan',
        ])
            ->whereIn('id_berkas', $validated['berkas_id'])
            ->get();

        $berkasSudahFinal = $berkasTerpilih->where(
            'status',
            'sudah_nota_dinas'
        );

        if ($berkasSudahFinal->isNotEmpty()) {
            return back()->withErrors([
                'berkas_id' => 'Ada berkas yang sudah menjadi Nota Dinas dan tidak dapat dipilih kembali.',
            ]);
        }

        $idSeksi = $berkasTerpilih
            ->pluck('id_seksi')
            ->filter()
            ->unique();

        if ($idSeksi->count() !== 1) {
            return back()->withErrors([
                'berkas_id' => 'Berkas yang dipilih harus berasal dari seksi yang sama.',
            ]);
        }

        $seksi = $berkasTerpilih
            ->first()
            ->seksi;

        if (! $seksi) {
            return back()->withErrors([
                'berkas_id' => 'Data seksi pada berkas tidak ditemukan.',
            ]);
        }

        $tahunSekarang = now()->year;

        $nomorTerakhir = NotaDinas::where('tahun', $tahunSekarang)
            ->where('status', 'final')
            ->max('nomor');

        $nomorBaru = $nomorTerakhir
            ? $nomorTerakhir + 1
            : 1;

        $jabatan = 'KKS '.$seksi->nama_seksi;

        $notaDinas = DB::transaction(function () use (
            $nomorBaru,
            $tahunSekarang,
            $berkasTerpilih,
            $jabatan
        ) {

            $nota = NotaDinas::create([
                'nomor' => $nomorBaru,
                'tahun' => $tahunSekarang,

                'kepada' => 'Kepala Seksi Penetapan Hak dan Pendaftaran',

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
        $notaDinas = NotaDinas::with([
            'berkas.seksi',
            'berkas.jenisLayanan',
        ])
            ->orderByDesc('tahun')
            ->orderByDesc('nomor')
            ->get();

        return view('nota-dinas.riwayat', compact('notaDinas'));
    }
}
