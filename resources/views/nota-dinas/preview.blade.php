@extends('layouts.app')

@section('title', 'Preview Nota Dinas')

@section('content')

<div class="preview-page">

    {{-- =========================================================
        HEADER APLIKASI
    ========================================================== --}}

    <div class="screen-header">

        <h1>
            Preview Nota Dinas
        </h1>

        <p>
            Periksa sebelum dicetak. Setelah nota berhasil disimpan,
    klik "Selesai & Finalkan" untuk menetapkan nota sebagai final.
        </p>

    </div>


    {{-- =========================================================
        PREVIEW KERTAS
    ========================================================== --}}

    <div class="preview-wrapper">

        <div id="notaPreview" class="nota-paper">

            <div class="nota-content">


                {{-- =================================================
                    JUDUL NOTA DINAS
                ================================================== --}}

                <div class="nota-title">
                    NOTA DINAS NO. {{ $notaDinas->nomor }}
                    TAHUN {{ $notaDinas->tahun }}
                </div>


                {{-- =================================================
                    INFORMASI NOTA DINAS
                ================================================== --}}

                <table class="info-table">

                    <tbody>

                        <tr>

                            <td class="label">
                                Kepada
                            </td>

                            <td class="colon">
                                :
                            </td>

                            <td class="info-value">
                                {{ $notaDinas->kepada }}
                            </td>

                        </tr>


                        <tr>

                            <td class="label">
                                Dari
                            </td>

                            <td class="colon">
                                :
                            </td>

                            <td class="info-value">
                                {{ $notaDinas->dari }}
                            </td>

                        </tr>


                        <tr>

                            <td class="label">
                                Tanggal
                            </td>

                            <td class="colon">
                                :
                            </td>

                            <td class="info-value">
                                {{ $notaDinas->tanggal?->format('d/m/Y') }}
                            </td>

                        </tr>

                    </tbody>

                </table>


                {{-- =================================================
                    TABEL BERKAS
                ================================================== --}}

                <div class="table-container">

                    <table id="tabelNotaDinas">

                        <thead>

                            <tr>

                                <th class="col-no">
                                    NO
                                </th>

                                <th class="col-berkas">
                                    No. Berkas
                                </th>

                                <th class="col-tanggal">
                                    Tanggal<br>Pendaftaran
                                </th>

                                <th class="col-nohak">
                                    NO HAK
                                </th>

                                <th class="col-nib">
                                    NIB<br>Elektronik
                                </th>

                                <th class="col-pemohon">
                                    Pemohon
                                </th>

                                <th class="col-tempat">
                                    Tempat, Tanggal Lahir<br>Pemohon
                                </th>

                                <th class="col-akta">
                                    Nomor Akta
                                </th>

                                <th class="col-tanggal-akta">
                                    Tanggal Akta
                                </th>

                                <th class="col-ppat">
                                    PPAT
                                </th>

                                <th class="col-desa">
                                    Desa / Kelurahan
                                </th>

                                <th class="col-kecamatan">
                                    Kecamatan
                                </th>

                                <th class="col-luas">
                                    Luas<br>(m²)
                                </th>

                                <th class="col-ket">
                                    Ket
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($notaDinas->berkas as $index => $berkas)

                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>

                                    <td>
                                        {{ $berkas->no_berkas ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $berkas->tanggal_pendaftaran?->format('d/m/Y') ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $berkas->no_hak ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $berkas->nib_elektronik ?? '-' }}
                                    </td>

                                    <td>
                                        {{ strtoupper($berkas->nama_pemohon ?? '-') }}
                                    </td>

                                    <td>
                                        {{ strtoupper($berkas->tempat_lahir ?? '-') }},
                                        {{ $berkas->tanggal_lahir?->format('d/m/Y') ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $berkas->nomor_akta ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $berkas->tanggal_akta?->format('d/m/Y') ?? '-' }}
                                    </td>

                                    <td>
                                        {{ strtoupper($berkas->ppat ?? '-') }}
                                    </td>

                                    <td>
                                        {{ strtoupper($berkas->desa_kelurahan ?? '-') }}
                                    </td>

                                    <td>
                                        {{ strtoupper($berkas->kecamatan ?? '-') }}
                                    </td>

                                    <td>
                                        {{
                                            rtrim(
                                                rtrim(
                                                    number_format(
                                                        $berkas->luas ?? 0,
                                                        2,
                                                        ',',
                                                        '.'
                                                    ),
                                                    '0'
                                                ),
                                                ','
                                            )
                                        }}
                                    </td>

                                    <td>
                                        {{ strtoupper($berkas->keterangan ?? '-') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="14" class="empty-data">
                                        Tidak ada berkas yang dipilih.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- =================================================
                    TANDA TANGAN
                ================================================== --}}

                <div class="signature-area">

                    <div class="signature-position">

                        <div class="signature-title">
                            {{ $jabatanKoordinator }}
                        </div>

                        <div class="signature-space"></div>

                        <div class="signature-name">
                            {{ $seksi->nama_koordinator }}
                        </div>

                        <div class="signature-nip">
                            NIP. {{ $seksi->nip_koordinator }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        BUTTON
    ========================================================== --}}

    <div class="action-buttons">

    {{-- BATAL --}}
    <a
        href="{{ route('berkas.pilih') }}"
        class="btn-cancel"
    >
        Batal
    </a>


    {{-- CETAK --}}
    <form
        action="{{ route('nota-dinas.cetak', [
            'notaDinas' => $notaDinas->getKey()
        ]) }}"
        method="POST"
    >

        @csrf

        <button
            type="submit"
            class="btn-print"
        >
            Cetak
        </button>

    </form>


    {{-- FINALISASI --}}
    <form
        action="{{ route('nota-dinas.finalisasi', [
            'notaDinas' => $notaDinas->getKey()
        ]) }}"
        method="POST"
        onsubmit="return confirm(
            'Pastikan Nota Dinas sudah berhasil disimpan/dicetak. Setelah difinalkan, nota dan berkas tidak dapat digunakan kembali. Lanjutkan?'
        );"
    >

        @csrf

        <button
            type="submit"
            class="btn-final"
        >
            Selesai & Finalkan
        </button>

    </form>

</div>

</div>



<style>

/* =========================================================
   GLOBAL
========================================================= */

.preview-page,
.preview-page * {
    font-family: Arial, Helvetica, sans-serif;
    box-sizing: border-box;
}


/* =========================================================
   HALAMAN PREVIEW
========================================================= */

.preview-page {

    width: 100%;
    min-height: 100vh;

    background: #f3f4f6;

    padding: 24px;

}


/* =========================================================
   HEADER
========================================================= */

.screen-header {

    width: 100%;
    max-width: 1500px;

    margin: 0 auto 18px;

}

.screen-header h1 {

    margin: 0;

    font-size: 24px;

    font-weight: 700;

    color: #172033;

}

.screen-header p {

    margin: 5px 0 0;

    font-size: 15px;

    color: #667085;

}


/* =========================================================
   WRAPPER
========================================================= */

.preview-wrapper {

    width: 100%;

    max-width: 1500px;

    margin: 0 auto;

    overflow-x: auto;

    overflow-y: hidden;

    padding-bottom: 12px;

}


/* =========================================================
   KERTAS A4 LANDSCAPE
========================================================= */

.nota-paper {

    width: 277mm;

    min-width: 277mm;

    min-height: 190mm;

    margin: 0 auto;

    padding: 12mm 12mm 10mm;

    background: #fff;

    color: #000;

    box-shadow: 0 2px 10px rgba(0,0,0,.08);

}


/* =========================================================
   JUDUL
========================================================= */

.nota-title {

    font-size: 15px;

    font-weight: 700;

    text-transform: uppercase;

    margin-bottom: 5mm;

}


/* =========================================================
   INFORMASI
========================================================= */

.info-table {

    border-collapse: collapse;

    width: auto;

    font-size: 11px;

    margin: 0 0 5mm 0;

}


.info-table td {

    padding: 1px 0;

    vertical-align: top;

    line-height: 1.4;

}


.info-table .label {

    width: 20mm;

    white-space: nowrap;

}


.info-table .colon {

    width: 5mm;

    text-align: center;

}


.info-table .info-value {

    padding-left: 1mm;

}


/* =========================================================
   TABEL
========================================================= */

.table-container {

    width: 100%;

    overflow: visible;

}


#tabelNotaDinas {

    width: 100%;

    border-collapse: collapse;

    table-layout: fixed;

    font-size: 9px;

    color: #000;

}


#tabelNotaDinas th,
#tabelNotaDinas td {

    border: 1px solid #000;

    padding: 3px 3px;

    vertical-align: middle;

    text-align: center;

    line-height: 1.15;

    word-wrap: break-word;

    overflow-wrap: break-word;

}


#tabelNotaDinas th {

    font-weight: 700;

    height: 11mm;

    background: #fff;

}


#tabelNotaDinas td {

    height: 7mm;

}


/* =========================================================
   LEBAR KOLOM
========================================================= */

#tabelNotaDinas .col-no {
    width: 3%;
}

#tabelNotaDinas .col-berkas {
    width: 7%;
}

#tabelNotaDinas .col-tanggal {
    width: 7%;
}

#tabelNotaDinas .col-nohak {
    width: 6%;
}

#tabelNotaDinas .col-nib {
    width: 6%;
}

#tabelNotaDinas .col-pemohon {
    width: 12%;
}

#tabelNotaDinas .col-tempat {
    width: 13%;
}

#tabelNotaDinas .col-akta {
    width: 7%;
}

#tabelNotaDinas .col-tanggal-akta {
    width: 7%;
}

#tabelNotaDinas .col-ppat {
    width: 6%;
}

#tabelNotaDinas .col-desa {
    width: 9%;
}

#tabelNotaDinas .col-kecamatan {
    width: 9%;
}

#tabelNotaDinas .col-luas {
    width: 5%;
}

#tabelNotaDinas .col-ket {
    width: 5%;
}


/* =========================================================
   DATA KOSONG
========================================================= */

.empty-data {

    padding: 10px !important;

    text-align: center !important;

}


/* =========================================================
   TANDA TANGAN
========================================================= */

.signature-area {

    width: 100%;

    margin-top: 9mm;

    display: flex;

    justify-content: flex-end;

}


.signature-position {

    width: 72mm;

    margin-right: 5mm;

    text-align: center;

}


.signature-title {

    font-size: 10px;

    font-weight: 700;

    line-height: 1.3;

}


.signature-space {

    height: 16mm;

}


.signature-name {

    font-size: 11px;

    font-weight: 700;

    text-decoration: underline;

    margin-bottom: 1.5mm;

}


.signature-nip {

    font-size: 10px;

}


/* =========================================================
   BUTTON
========================================================= */

.action-buttons {

    width: 100%;

    max-width: 1500px;

    margin: 18px auto 0;

    display: flex;

    justify-content: flex-end;

    gap: 10px;

}


.btn-cancel,
.btn-print {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    height: 38px;

    padding: 0 24px;

    border-radius: 6px;

    font-size: 14px;

    font-weight: 600;

    text-decoration: none;

    cursor: pointer;

}


.btn-cancel {

    background: white;

    color: #344054;

    border: 1px solid #d0d5dd;

}


.btn-print {

    background: #003b7a;

    color: white;

    border: 1px solid #003b7a;

}


.btn-final {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    height: 38px;

    padding: 0 24px;

    border-radius: 6px;

    font-size: 14px;
    font-weight: 600;

    cursor: pointer;

    background: #198754;
    color: white;

    border: 1px solid #198754;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .preview-page {

        padding: 16px 10px;

    }

    .screen-header h1 {

        font-size: 20px;

    }

    .screen-header p {

        font-size: 13px;

    }

    .nota-paper {

        margin-left: 0;

        margin-right: 0;

    }

}


/* =========================================================
   PRINT
========================================================= */

@media print {

    @page {

        size: A4 landscape;

        margin: 10mm;

    }


    html,
    body {

        width: 100% !important;

        margin: 0 !important;

        padding: 0 !important;

        background: white !important;

    }


    aside,
    header,
    nav,
    .screen-header,
    .action-buttons {

        display: none !important;

    }


    .preview-page {

        width: 100% !important;

        min-height: auto !important;

        margin: 0 !important;

        padding: 0 !important;

        background: white !important;

    }


    .preview-wrapper {

        width: 100% !important;

        max-width: none !important;

        margin: 0 !important;

        padding: 0 !important;

        overflow: visible !important;

    }


    .nota-paper {

        width: 100% !important;

        min-width: 0 !important;

        min-height: auto !important;

        margin: 0 !important;

        padding: 0 !important;

        box-shadow: none !important;

    }


    /* JUDUL */

    .nota-title {

        font-size: 15px !important;

        margin-bottom: 5mm !important;

    }


    /* INFO */

    .info-table {

        font-size: 10.5px !important;

        margin-bottom: 5mm !important;

    }


    .info-table td {

        padding: 1px 0 !important;

        line-height: 1.35 !important;

    }


    .info-table .label {

        width: 20mm !important;

    }


    .info-table .colon {

        width: 5mm !important;

    }


    /* TABEL */

    #tabelNotaDinas {

        width: 100% !important;

        table-layout: fixed !important;

        font-size: 8.5px !important;

    }


    #tabelNotaDinas th,
    #tabelNotaDinas td {

        border: 1px solid #000 !important;

        padding: 2.5px 3px !important;

        color: #000 !important;

        background: white !important;

        text-align: center !important;

    }


    #tabelNotaDinas th {

        font-size: 8.5px !important;

        height: 10mm !important;

    }


    #tabelNotaDinas td {

        font-size: 8.5px !important;

        line-height: 1.15 !important;

    }


    #tabelNotaDinas tr {

        page-break-inside: avoid !important;

        break-inside: avoid !important;

    }


    #tabelNotaDinas thead {

        display: table-header-group;

    }


    #tabelNotaDinas tbody {

        display: table-row-group;

    }


    /* TANDA TANGAN */

    .signature-area {

        margin-top: 8mm !important;

        justify-content: flex-end !important;

    }


    .signature-position {

        width: 72mm !important;

        margin-right: 5mm !important;

    }


    .signature-title {

        font-size: 9px !important;

    }


    .signature-space {

        height: 15mm !important;

    }


    .signature-name {

        font-size: 10px !important;

    }


    .signature-nip {

        font-size: 9px !important;

    }

}

</style>


{{-- =========================================================
     AUTO PRINT + NAMA FILE
========================================================== --}}

@if(session('print'))

<script>

window.addEventListener('load', function () {

    /*
    |--------------------------------------------------------------------------
    | SIMPAN JUDUL ASLI
    |--------------------------------------------------------------------------
    */

    const originalTitle = document.title;


    /*
    |--------------------------------------------------------------------------
    | NAMA FILE PDF
    |--------------------------------------------------------------------------
    |
    | Browser biasanya menggunakan document.title
    | sebagai nama file ketika memilih Save to PDF.
    |
    */

    document.title =
        'Nota Dinas No. {{ $notaDinas->nomor }} Tahun {{ $notaDinas->tahun }}';


    /*
    |--------------------------------------------------------------------------
    | BUKA PRINT DIALOG
    |--------------------------------------------------------------------------
    */

    setTimeout(function () {

        window.print();

    }, 500);


    /*
    |--------------------------------------------------------------------------
    | KEMBALIKAN JUDUL SETELAH PRINT
    |--------------------------------------------------------------------------
    */

    window.onafterprint = function () {

        document.title = originalTitle;

    };

});

</script>

@endif

@endsection