<?php

namespace App\Http\Controllers;

use App\Models\NotaDinas;
use App\Models\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaDinasController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BUAT NOTA DINAS
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'berkas_id' => ['required', 'array', 'min:1'],
            'berkas_id.*' => ['required', 'exists:berkas,id_berkas'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | AMBIL BERKAS YANG DIPILIH
        |--------------------------------------------------------------------------
        */

        $berkasTerpilih = Berkas::with([
            'seksi',
            'jenisLayanan'
        ])
            ->whereIn('id_berkas', $validated['berkas_id'])
            ->get();


        /*
        |--------------------------------------------------------------------------
        | CEK BERKAS SUDAH FINAL
        |--------------------------------------------------------------------------
        */

        $berkasSudahFinal = $berkasTerpilih->where(
            'status',
            'sudah_nota_dinas'
        );

        if ($berkasSudahFinal->isNotEmpty()) {
            return back()->withErrors([
                'berkas_id' =>
                    'Ada berkas yang sudah menjadi Nota Dinas dan tidak dapat dipilih kembali.'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CEK SEMUA BERKAS HARUS DARI SEKSI YANG SAMA
        |--------------------------------------------------------------------------
        */

        $idSeksi = $berkasTerpilih
            ->pluck('id_seksi')
            ->filter()
            ->unique();

        if ($idSeksi->count() !== 1) {
            return back()->withErrors([
                'berkas_id' =>
                    'Berkas yang dipilih harus berasal dari seksi yang sama.'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA SEKSI
        |--------------------------------------------------------------------------
        */

        $seksi = $berkasTerpilih
            ->first()
            ->seksi;

        if (!$seksi) {
            return back()->withErrors([
                'berkas_id' =>
                    'Data seksi pada berkas tidak ditemukan.'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | NOMOR NOTA DINAS
        |
        | Nomor dibuat berurutan berdasarkan tahun.
        |
        | Contoh:
        | 289/2026
        | 290/2026
        | 291/2026
        | 292/2026
        |--------------------------------------------------------------------------
        */

        $tahunSekarang = now()->year;

        $nomorTerakhir = NotaDinas::where('tahun', $tahunSekarang)
            ->where('status', 'final')
            ->max('nomor');

        $nomorBaru = $nomorTerakhir
            ? $nomorTerakhir + 1
            : 1;


        /*
        |--------------------------------------------------------------------------
        | JABATAN / DARI
        |--------------------------------------------------------------------------
        |
        | Nama seksi dari database:
        |
        | Pemeliharaan Hak Tanah, Ruang dan Pembinaan PPAT
        |
        | Akan ditampilkan:
        |
        | KKS Pemeliharaan Hak Tanah, Ruang dan Pembinaan PPAT
        |--------------------------------------------------------------------------
        */

        $jabatan = 'KKS ' . $seksi->nama_seksi;


        /*
        |--------------------------------------------------------------------------
        | BUAT NOTA DINAS
        |--------------------------------------------------------------------------
        */

        $notaDinas = DB::transaction(function () use (
            $nomorBaru,
            $tahunSekarang,
            $seksi,
            $berkasTerpilih,
            $jabatan
        ) {

            $nota = NotaDinas::create([
                'nomor' => $nomorBaru,

                'tahun' => $tahunSekarang,

                /*
                 * Kepada tetap ditujukan kepada
                 * Kepala Seksi Penetapan Hak dan Pendaftaran.
                 */
                'kepada' =>
                    'Kepala Seksi Penetapan Hak dan Pendaftaran',

                /*
                 * Dari mengikuti seksi yang dipilih.
                 */
                'dari' => $jabatan,

                'tanggal' => now(),

                'status' => 'draft',
            ]);


            /*
            |--------------------------------------------------------------------------
            | HUBUNGKAN BERKAS DENGAN NOTA DINAS
            |--------------------------------------------------------------------------
            */

            $nota->berkas()->attach(
                $berkasTerpilih->pluck('id_berkas')->toArray()
            );


            return $nota;
        });


        /*
        |--------------------------------------------------------------------------
        | MASUK KE HALAMAN PREVIEW
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
        'nota-dinas.preview',
        [
            'notaDinas' => $notaDinas->getKey()
        ]
    );
    }


    /*
    |--------------------------------------------------------------------------
    | PREVIEW
    |--------------------------------------------------------------------------
    */

    public function preview(NotaDinas $notaDinas)
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD RELASI
        |--------------------------------------------------------------------------
        */

        $notaDinas->load([
            'berkas.seksi',
            'berkas.jenisLayanan'
        ]);


        /*
        |--------------------------------------------------------------------------
        | AMBIL SEKSI DARI BERKAS PERTAMA
        |--------------------------------------------------------------------------
        */

        $seksi = $notaDinas
            ->berkas
            ->first()
            ?->seksi;


        if (!$seksi) {
            return redirect()
                ->route('berkas.pilih')
                ->withErrors([
                    'berkas_id' =>
                        'Seksi dari Nota Dinas tidak ditemukan.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | JABATAN KOORDINATOR
        |--------------------------------------------------------------------------
        */

        $jabatanKoordinator =
            'KKS ' . $seksi->nama_seksi;


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN PREVIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'nota-dinas.preview',
            compact(
                'notaDinas',
                'seksi',
                'jabatanKoordinator'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CETAK
    |--------------------------------------------------------------------------
    */

public function cetak(Request $request, NotaDinas $notaDinas)
{
    /*
    |--------------------------------------------------------------------------
    | LOAD DATA
    |--------------------------------------------------------------------------
    */

    $notaDinas->load([
        'berkas.seksi',
        'berkas.jenisLayanan'
    ]);

    /*
    |--------------------------------------------------------------------------
    | BELUM FINAL
    |--------------------------------------------------------------------------
    |
    | Method ini hanya mengembalikan halaman preview
    | dan memerintahkan browser membuka print dialog.
    |
    */

    return redirect()
        ->route('nota-dinas.preview', [
            'notaDinas' => $notaDinas->getKey()
        ])
        ->with('print', true);
}

/*
|--------------------------------------------------------------------------
| FINALISASI NOTA DINAS
|--------------------------------------------------------------------------
*/

public function finalisasi(Request $request, NotaDinas $notaDinas)
{
    /*
    |--------------------------------------------------------------------------
    | Pastikan masih draft
    |--------------------------------------------------------------------------
    */

    if ($notaDinas->status === 'final') {
        return redirect()
            ->route('berkas.pilih')
            ->with('success', 'Nota Dinas sudah final.');
    }


    /*
    |--------------------------------------------------------------------------
    | FINALISASI
    |--------------------------------------------------------------------------
    */

    DB::transaction(function () use ($notaDinas) {

        // Semua berkas yang ada di nota menjadi final
        $notaDinas->berkas()->update([
            'status' => 'sudah_nota_dinas'
        ]);

        // Nota Dinas menjadi final
        $notaDinas->update([
            'status' => 'final'
        ]);
    });


    /*
    |--------------------------------------------------------------------------
    | KEMBALI
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('berkas.pilih')
        ->with(
            'success',
            'Nota Dinas No. ' .
            $notaDinas->nomor .
            ' Tahun ' .
            $notaDinas->tahun .
            ' berhasil difinalkan.'
        );
}
}