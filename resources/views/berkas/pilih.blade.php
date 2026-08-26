@extends('layouts.app')

@section('title', 'Pilih Berkas')

@section('content')

<div class="bg-white rounded-lg shadow-sm p-6">

    {{-- ============================= --}}
    {{-- HEADER --}}
    {{-- ============================= --}}
    <div class="mb-6">
        <h1 class="text-lg font-bold text-gray-800">
            Pilih Berkas
        </h1>

        <p class="text-sm text-gray-500">
            Centang berkas yang ingin dijadikan nota dinas.
            Berkas yang sudah final tidak dapat dipilih lagi.
        </p>
    </div>


    {{-- ============================= --}}
    {{-- ERROR --}}
    {{-- ============================= --}}
    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 text-red-700 text-sm px-4 py-3">

            <p class="font-semibold mb-1">
                Ada masalah:
            </p>

            <ul class="list-disc list-inside space-y-0.5">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>
    @endif


    {{-- ============================= --}}
    {{-- SUCCESS --}}
    {{-- ============================= --}}
    @if (session('success'))
        <div class="mb-6 rounded-md bg-green-50 text-green-700 text-sm px-4 py-3">
            {{ session('success') }}
        </div>
    @endif


    {{-- ============================= --}}
    {{-- SEARCH + BUTTON FILTER --}}
    {{-- ============================= --}}
    <div class="flex items-center gap-3 mb-4">

        {{-- SEARCH --}}
        <div class="relative flex-1">

            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">

                <iconify-icon
                    icon="material-symbols:search"
                    width="20"
                    height="20">
                </iconify-icon>

            </span>

            <input
                type="text"
                id="searchBerkas"
                placeholder="Search..."
                class="w-full h-10 pl-10 pr-4 rounded-md border border-gray-300
                       text-sm text-gray-700 placeholder-gray-400
                       focus:outline-none focus:ring-1 focus:ring-[#003B7A]
                       focus:border-[#003B7A]"
            >

        </div>


        {{-- BUTTON FILTER --}}
        <button
            type="button"
            id="btnFilter"
            class="h-10 px-4 flex items-center gap-2 rounded-md
                   border border-gray-300 bg-white text-gray-600 text-sm
                   hover:bg-gray-50 transition"
        >

            <iconify-icon
                icon="material-symbols:filter-list"
                width="20"
                height="20">
            </iconify-icon>

            <span>
                Filter
            </span>

        </button>

    </div>


    {{-- ============================= --}}
    {{-- PANEL FILTER --}}
    {{-- ============================= --}}
    <div
        id="filterPanel"
        class="hidden mb-4 p-4 rounded-md border border-gray-200 bg-gray-50"
    >

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">


            {{-- ============================= --}}
            {{-- FILTER STATUS --}}
            {{-- ============================= --}}
            <div>

                <label
                    class="block text-xs font-medium text-gray-600 mb-1"
                >
                    Status
                </label>

                <select
                    id="filterStatus"
                    class="w-full h-10 px-3 rounded-md border border-gray-300
                           bg-white text-sm text-gray-700
                           focus:outline-none focus:ring-1
                           focus:ring-[#003B7A]"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option value="belum">
                        Belum
                    </option>

                    <option value="final">
                        Final
                    </option>

                </select>

            </div>


            {{-- ============================= --}}
            {{-- FILTER SEKSI --}}
            {{-- ============================= --}}
            <div>

                <label
                    class="block text-xs font-medium text-gray-600 mb-1"
                >
                    Seksi
                </label>

                <select
                    id="filterSeksi"
                    class="w-full h-10 px-3 rounded-md border border-gray-300
                           bg-white text-sm text-gray-700
                           focus:outline-none focus:ring-1
                           focus:ring-[#003B7A]"
                >

                    <option value="">
                        Semua Seksi
                    </option>

                    @foreach ($seksi as $item)

                        <option value="{{ strtolower(trim($item->nama_seksi)) }}">
                            {{ $item->nama_seksi }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- ============================= --}}
            {{-- FILTER JENIS LAYANAN --}}
            {{-- ============================= --}}
            <div>

                <label
                    class="block text-xs font-medium text-gray-600 mb-1"
                >
                    Jenis Layanan
                </label>

                <select
                    id="filterJenisLayanan"
                    class="w-full h-10 px-3 rounded-md border border-gray-300
                           bg-white text-sm text-gray-700
                           focus:outline-none focus:ring-1
                           focus:ring-[#003B7A]"
                >

                    <option value="">
                        Semua Jenis Layanan
                    </option>

                    @foreach (
                        $berkasList
                            ->pluck('jenisLayanan.nama_layanan')
                            ->filter()
                            ->unique()
                            ->sort()
                    as $jenis)

                        <option value="{{ strtolower(trim($jenis)) }}">
                            {{ $jenis }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        {{-- ============================= --}}
        {{-- RESET --}}
        {{-- ============================= --}}
        <div class="flex justify-end mt-3">

            <button
                type="button"
                id="resetFilter"
                class="text-sm text-gray-500 hover:text-[#003B7A]"
            >
                Reset Filter
            </button>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- FORM --}}
    {{-- ============================= --}}
    <form
        action="{{ route('nota-dinas.store') }}"
        method="POST"
    >

        @csrf


        {{-- ============================= --}}
        {{-- TABEL --}}
        {{-- ============================= --}}
        <div class="overflow-x-auto border border-gray-200 rounded-lg">

            <table
                class="w-full text-sm"
                id="tabelBerkas"
            >

                <thead class="bg-[#003B7A] text-white">

                    <tr>

                        <th class="px-4 py-3 w-10">
                        </th>

                        <th class="px-4 py-3 text-left">
                            No Berkas
                        </th>

                        <th class="px-4 py-3 text-left">
                            Pemohon
                        </th>

                        <th class="px-4 py-3 text-left">
                            Seksi
                        </th>

                        <th class="px-4 py-3 text-left">
                            Jenis Layanan
                        </th>

                        <th class="px-4 py-3 text-left">
                            Tanggal Daftar
                        </th>

                        <th class="px-4 py-3 text-center">
                            Aksi
                        </th>

                        <th class="px-4 py-3 text-center">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse ($berkasList as $berkas)

                        @php

                            $isFinal =
                                $berkas->status === 'sudah_nota_dinas';

                            $namaSeksi =
                                $berkas->seksi->nama_seksi ?? '';

                            $namaJenis =
                                $berkas->jenisLayanan->nama_layanan ?? '';

                        @endphp


                        <tr
                            class="{{ $isFinal ? 'opacity-60' : '' }}"

                            {{-- DATA UNTUK JAVASCRIPT FILTER --}}
                            data-seksi="{{ strtolower(trim($namaSeksi)) }}"

                            data-jenis="{{ strtolower(trim($namaJenis)) }}"

                            data-status="{{ $isFinal ? 'final' : 'belum' }}"
                        >


                            {{-- ============================= --}}
                            {{-- CHECKBOX --}}
                            {{-- ============================= --}}
                            <td class="px-4 py-3">

                                <input
                                    type="checkbox"
                                    name="berkas_id[]"
                                    value="{{ $berkas->id_berkas }}"
                                    class="berkas-checkbox"

                                    {{ $isFinal ? 'disabled' : '' }}
                                >

                            </td>


                            {{-- ============================= --}}
                            {{-- NO BERKAS --}}
                            {{-- ============================= --}}
                            <td class="px-4 py-3 whitespace-nowrap">

                                {{ $berkas->no_berkas }}

                            </td>


                            {{-- ============================= --}}
                            {{-- PEMOHON --}}
                            {{-- ============================= --}}
                            <td class="px-4 py-3">

                                {{ $berkas->nama_pemohon }}

                            </td>


                            {{-- ============================= --}}
                            {{-- SEKSI --}}
                            {{-- ============================= --}}
                            <td class="px-4 py-3">

                                {{ $namaSeksi ?: '-' }}

                            </td>


                            {{-- ============================= --}}
                            {{-- JENIS LAYANAN --}}
                            {{-- ============================= --}}
                            <td class="px-4 py-3">

                                {{ $namaJenis ?: '-' }}

                            </td>


                            {{-- ============================= --}}
                            {{-- TANGGAL --}}
                            {{-- ============================= --}}
                            <td class="px-4 py-3 whitespace-nowrap">

                                {{ $berkas->tanggal_pendaftaran?->format('d/m/Y') ?? '-' }}

                            </td>


                            {{-- ============================= --}}
                            {{-- AKSI --}}
                            {{-- ============================= --}}
                            <td class="px-4 py-3 text-center">

                                @if ($isFinal)

                                    <iconify-icon
                                        icon="material-symbols:do-not-disturb-on-outline"
                                        width="20"
                                        height="20"
                                        class="text-gray-400">
                                    </iconify-icon>

                                @else

                                    <a
                                        href="{{ Route::has('berkas.edit')
                                            ? route('berkas.edit', $berkas->id_berkas)
                                            : '#' }}"
                                        class="text-[#003B7A] hover:text-[#002f62]"
                                    >

                                        <iconify-icon
                                            icon="material-symbols:edit-outline"
                                            width="20"
                                            height="20">
                                        </iconify-icon>

                                    </a>

                                @endif

                            </td>


                            {{-- ============================= --}}
                            {{-- STATUS --}}
                            {{-- ============================= --}}
                            <td class="px-4 py-3 text-center">

                                @if ($isFinal)

                                    <span
                                        class="px-3 py-1 rounded-full text-xs
                                               font-semibold bg-[#003B7A]
                                               text-white"
                                    >
                                        Final
                                    </span>

                                @else

                                    <span
                                        class="px-3 py-1 rounded-full text-xs
                                               font-semibold bg-[#F5C542]
                                               text-gray-800"
                                    >
                                        Belum
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="px-4 py-6 text-center text-gray-400"
                            >
                                Belum ada berkas
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- ============================= --}}
        {{-- FOOTER --}}
        {{-- ============================= --}}
        <div class="flex items-center justify-between mt-4">

            <p class="text-sm text-gray-500">

                <span id="jumlahDipilih">
                    0
                </span>

                berkas dipilih

                <span class="text-xs text-gray-400 block">
                    *Berkas status "Final" tidak dapat dipilih lagi
                </span>

            </p>


            <div class="flex gap-3">

                <a
                    href="{{ route('berkas.create') }}"
                    class="px-4 py-2 text-sm rounded-md
                           border border-gray-300 text-gray-600
                           hover:bg-gray-50 transition"
                >
                    Kembali
                </a>


                <button
                    type="submit"
                    id="btnCetak"
                    disabled
                    class="px-5 py-2 text-sm rounded-md
                           bg-gray-300 text-gray-500
                           font-medium cursor-not-allowed transition"
                >
                    Cetak Nota Dinas
                </button>

            </div>

        </div>

    </form>

</div>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {


    // ==========================================
    // ELEMENT
    // ==========================================

    const counter =
        document.getElementById('jumlahDipilih');

    const btnCetak =
        document.getElementById('btnCetak');

    const rows =
        document.querySelectorAll(
            '#tabelBerkas tbody tr[data-seksi]'
        );

    const searchInput =
        document.getElementById('searchBerkas');

    const btnFilter =
        document.getElementById('btnFilter');

    const filterPanel =
        document.getElementById('filterPanel');

    const filterStatus =
        document.getElementById('filterStatus');

    const filterSeksi =
        document.getElementById('filterSeksi');

    const filterJenisLayanan =
        document.getElementById('filterJenisLayanan');

    const resetFilter =
        document.getElementById('resetFilter');


    // ==========================================
    // UPDATE TOMBOL CETAK
    // ==========================================

    function updateTombolCetak() {

        const jumlah =
            document.querySelectorAll(
                '.berkas-checkbox:checked'
            ).length;


        // Update counter
        counter.textContent = jumlah;


        // ===============================
        // ADA YANG DIPILIH
        // ===============================

        if (jumlah > 0) {

            btnCetak.disabled = false;


            btnCetak.classList.remove(
                'bg-gray-300',
                'text-gray-500',
                'cursor-not-allowed'
            );


            btnCetak.classList.add(
                'bg-[#003B7A]',
                'text-white',
                'cursor-pointer'
            );

        }


        // ===============================
        // TIDAK ADA YANG DIPILIH
        // ===============================

        else {

            btnCetak.disabled = true;


            btnCetak.classList.remove(
                'bg-[#003B7A]',
                'text-white',
                'cursor-pointer'
            );


            btnCetak.classList.add(
                'bg-gray-300',
                'text-gray-500',
                'cursor-not-allowed'
            );

        }

    }


    // ==========================================
    // CHECKBOX
    // ==========================================

    document
        .querySelectorAll('.berkas-checkbox')
        .forEach(function (checkbox) {

            checkbox.addEventListener(
                'change',
                updateTombolCetak
            );

        });


    // ==========================================
    // BUKA / TUTUP FILTER
    // ==========================================

    btnFilter.addEventListener(
        'click',
        function () {

            filterPanel.classList.toggle(
                'hidden'
            );

        }
    );


    // ==========================================
    // APPLY FILTER
    // ==========================================

    function applyFilter() {


        // ===============================
        // NILAI FILTER
        // ===============================

        const keyword =
            searchInput.value
                .toLowerCase()
                .trim();


        const status =
            filterStatus.value
                .toLowerCase()
                .trim();


        const seksi =
            filterSeksi.value
                .toLowerCase()
                .trim();


        const jenisLayanan =
            filterJenisLayanan.value
                .toLowerCase()
                .trim();


        // ===============================
        // LOOP ROW
        // ===============================

        rows.forEach(function (row) {


            // ===============================
            // DATA ROW
            // ===============================

            const rowText =
                row.textContent
                    .toLowerCase();


            const rowSeksi =
                (row.dataset.seksi || '')
                    .toLowerCase()
                    .trim();


            const rowJenis =
                (row.dataset.jenis || '')
                    .toLowerCase()
                    .trim();


            const rowStatus =
                (row.dataset.status || '')
                    .toLowerCase()
                    .trim();


            // ===============================
            // SEARCH
            // ===============================

            const cocokSearch =
                keyword === '' ||
                rowText.includes(keyword);


            // ===============================
            // FILTER SEKSI
            // ===============================

            const cocokSeksi =
                seksi === '' ||
                rowSeksi === seksi;


            // ===============================
            // FILTER JENIS LAYANAN
            // ===============================

            const cocokJenis =
                jenisLayanan === '' ||
                rowJenis === jenisLayanan;


            // ===============================
            // FILTER STATUS
            // ===============================

            const cocokStatus =
                status === '' ||
                rowStatus === status;


            // ===============================
            // HASIL AKHIR
            // ===============================

            if (
                cocokSearch &&
                cocokSeksi &&
                cocokJenis &&
                cocokStatus
            ) {

                row.style.display = '';

            }

            else {

                row.style.display = 'none';

            }

        });

    }


    // ==========================================
    // SEARCH
    // ==========================================

    searchInput.addEventListener(
        'input',
        applyFilter
    );


    // ==========================================
    // FILTER STATUS
    // ==========================================

    filterStatus.addEventListener(
        'change',
        applyFilter
    );


    // ==========================================
    // FILTER SEKSI
    // ==========================================

    filterSeksi.addEventListener(
        'change',
        applyFilter
    );


    // ==========================================
    // FILTER JENIS LAYANAN
    // ==========================================

    filterJenisLayanan.addEventListener(
        'change',
        applyFilter
    );


    // ==========================================
    // RESET FILTER
    // ==========================================

    resetFilter.addEventListener(
        'click',
        function () {


            searchInput.value = '';

            filterStatus.value = '';

            filterSeksi.value = '';

            filterJenisLayanan.value = '';


            applyFilter();

        }
    );


    // ==========================================
    // INITIAL
    // ==========================================

    updateTombolCetak();

});

</script>

@endpush