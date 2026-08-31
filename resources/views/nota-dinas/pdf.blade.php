<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>
        Nota Dinas No. {{ $notaDinas->nomor }} Tahun {{ $notaDinas->tahun }}
    </title>

    <style>

        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            font-size: 9px;
            margin: 0;
            padding: 0;
        }



        .nota-title {

            font-size: 15px;

            font-weight: bold;

            text-transform: uppercase;

            margin-bottom: 5mm;

        }



        .info-table {

            border-collapse: collapse;

            width: auto;

            font-size: 10.5px;

            margin-bottom: 5mm;

        }

        .info-table td {

            padding: 1px 0;

            vertical-align: top;

            line-height: 1.35;

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



        #tabelNotaDinas {

            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;

            font-size: 8.5px;

        }

        #tabelNotaDinas th,
        #tabelNotaDinas td {

            border: 1px solid #000;

            padding: 2.5px 3px;

            vertical-align: middle;

            text-align: center;

            line-height: 1.15;

            word-wrap: break-word;

        }

        #tabelNotaDinas th {

            font-weight: bold;

            height: 10mm;

        }

        #tabelNotaDinas td {

            height: 7mm;

        }



        .col-no {
            width: 3%;
        }

        .col-berkas {
            width: 7%;
        }

        .col-tanggal {
            width: 7%;
        }

        .col-nohak {
            width: 6%;
        }

        .col-nib {
            width: 6%;
        }

        .col-pemohon {
            width: 12%;
        }

        .col-tempat {
            width: 13%;
        }

        .col-akta {
            width: 7%;
        }

        .col-tanggal-akta {
            width: 7%;
        }

        .col-ppat {
            width: 6%;
        }

        .col-desa {
            width: 9%;
        }

        .col-kecamatan {
            width: 9%;
        }

        .col-luas {
            width: 5%;
        }

        .col-ket {
            width: 5%;
        }



        .signature-area {

            width: 100%;

            margin-top: 8mm;

            text-align: right;

        }

        .signature-position {

            width: 72mm;

            margin-left: auto;

            margin-right: 5mm;

            text-align: center;

        }

        .signature-title {

            font-size: 9px;

            font-weight: bold;

            line-height: 1.3;

        }

        .signature-space {

            height: 15mm;

        }

        .signature-name {

            font-size: 10px;

            font-weight: bold;

            text-decoration: underline;

            margin-bottom: 1.5mm;

        }

        .signature-nip {

            font-size: 9px;

        }

        .empty-data {

            padding: 10px;

            text-align: center;

        }

    </style>

</head>


<body>


    {{-- =========================================================
         JUDUL NOTA DINAS
    ========================================================== --}}

    <div class="nota-title">

        NOTA DINAS NO.
        {{ $notaDinas->nomor }}

        TAHUN
        {{ $notaDinas->tahun }}

    </div>


    {{-- =========================================================
         INFORMASI NOTA DINAS
    ========================================================== --}}

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


    {{-- =========================================================
         TABEL BERKAS
    ========================================================== --}}

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

                    <td
                        colspan="14"
                        class="empty-data"
                    >

                        Tidak ada berkas yang dipilih.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =========================================================
         TANDA TANGAN
    ========================================================== --}}

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


</body>

</html>