@extends('layouts.app')

@section('title', 'Pilih Berkas')

@section('content')

    <div class="bg-white rounded-lg shadow-sm p-6">

        <div class="mb-6">
            <h1 class="text-lg font-bold text-gray-800">Pilih Berkas</h1>
            <p class="text-sm text-gray-500">
                Centang berkas yang ingin dijadikan nota dinas. Berkas yang sudah final tidak dapat dipilih lagi.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 text-red-700 text-sm px-4 py-3">
                <p class="font-semibold mb-1">Ada masalah:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 rounded-md bg-green-50 text-green-700 text-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

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

    {{-- TOMBOL FILTER --}}
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

        <span>Filter</span>
    </button>

</div>

{{-- PANEL FILTER --}}
<div
    id="filterPanel"
    class="hidden mb-4 p-4 rounded-md border border-gray-200 bg-gray-50"
>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- FILTER STATUS --}}
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">
                Status
            </label>

            <select
                id="filterStatus"
                class="w-full h-10 px-3 rounded-md border border-gray-300
                       bg-white text-sm text-gray-700
                       focus:outline-none focus:ring-1 focus:ring-[#003B7A]"
            >
                <option value="">Semua Status</option>
                <option value="belum">Belum</option>
                <option value="final">Final</option>
            </select>
        </div>

        {{-- FILTER JENIS LAYANAN --}}
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">
                Jenis Layanan
            </label>

            <select
                id="filterJenisLayanan"
                class="w-full h-10 px-3 rounded-md border border-gray-300
                       bg-white text-sm text-gray-700
                       focus:outline-none focus:ring-1 focus:ring-[#003B7A]"
            >
                <option value="">Semua Jenis Layanan</option>

                @foreach ($berkasList->pluck('jenisLayanan.nama_layanan')->filter()->unique()->sort() as $jenis)
                    <option value="{{ strtolower($jenis) }}">
                        {{ $jenis }}
                    </option>
                @endforeach

            </select>
        </div>

    </div>

    {{-- RESET FILTER --}}
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

        <form action="{{ route('nota-dinas.store') }}" method="POST">
            @csrf

            <div class="overflow-hidden border border-gray-200 rounded-lg">
                <table class="w-full text-sm" id="tabelBerkas">
                    <thead class="bg-[#003B7A] text-white">
                        <tr>
                            <th class="px-4 py-3 w-10"></th>
                            <th class="px-4 py-3 text-left">No Berkas</th>
                            <th class="px-4 py-3 text-left">Pemohon</th>
                            <th class="px-4 py-3 text-left">Jenis Layanan</th>
                            <th class="px-4 py-3 text-left">Tanggal Daftar</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                            <th class="px-4 py-3 text-center">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($berkasList as $berkas)
                            @php
                                // TODO: konfirmasi ke tim apa 'diproses' emang harus tetep bisa dipilih
                                $isFinal = $berkas->status === 'sudah_nota_dinas';
                            @endphp

                            <tr class="{{ $isFinal ? 'opacity-60' : '' }}">
                                <td class="px-4 py-3">
                                    <input type="checkbox" name="berkas_id[]" value="{{ $berkas->id_berkas }}"
                                        class="berkas-checkbox" {{ $isFinal ? 'disabled' : '' }}>
                                </td>
                                <td class="px-4 py-3">{{ $berkas->no_berkas }}</td>
                                <td class="px-4 py-3">{{ $berkas->nama_pemohon }}</td>
                                <td class="px-4 py-3">{{ $berkas->jenisLayanan->nama_layanan ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $berkas->tanggal_pendaftaran->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if ($isFinal)
                                        <iconify-icon icon="material-symbols:do-not-disturb-on-outline" width="20" height="20" class="text-gray-400"></iconify-icon>
                                    @else
                                        <a href="{{ Route::has('berkas.edit') ? route('berkas.edit', $berkas->id_berkas) : '#' }}" class="text-[#003B7A]">
                                            <iconify-icon icon="material-symbols:edit-outline" width="20" height="20"></iconify-icon>
                                        </a>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($isFinal)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[#003B7A] text-white">Final</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[#F5C542] text-gray-800">Belum</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-6 text-center text-gray-400">Belum ada berkas</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between mt-4">
                <p class="text-sm text-gray-500">
                    <span id="jumlahDipilih">0</span> berkas dipilih
                    <span class="text-xs text-gray-400 block">*Berkas status "Final" tidak dapat dipilih lagi</span>
                </p>
                <div class="flex gap-3">
                    <a href="{{ route('berkas.create') }}" class="px-4 py-2 text-sm rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50 transition">Kembali</a>
                    <button
                        type="button"
                        disabled
                        class="px-5 py-2 text-sm rounded-md bg-[#003B7A] text-white font-medium"
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

    const counter = document.getElementById('jumlahDipilih');

    const rows = document.querySelectorAll('#tabelBerkas tbody tr');

    const searchInput = document.getElementById('searchBerkas');

    const btnFilter = document.getElementById('btnFilter');

    const filterPanel = document.getElementById('filterPanel');

    const filterStatus = document.getElementById('filterStatus');

    const filterJenisLayanan = document.getElementById('filterJenisLayanan');

    const resetFilter = document.getElementById('resetFilter');


    // ==========================================
    // HITUNG BERKAS YANG DIPILIH
    // ==========================================

    document.querySelectorAll('.berkas-checkbox').forEach(cb => {

        cb.addEventListener('change', () => {

            counter.textContent =
                document.querySelectorAll(
                    '.berkas-checkbox:checked'
                ).length;

        });

    });


    // ==========================================
    // BUKA / TUTUP FILTER
    // ==========================================

    btnFilter.addEventListener('click', function () {

        filterPanel.classList.toggle('hidden');

    });


    // ==========================================
    // FUNGSI FILTER
    // ==========================================

    function applyFilter() {

        const keyword =
            searchInput.value.toLowerCase().trim();

        const status =
            filterStatus.value.toLowerCase();

        const jenisLayanan =
            filterJenisLayanan.value.toLowerCase();


        rows.forEach(row => {

            const rowText =
                row.textContent.toLowerCase();


            // CARI DENGAN SEARCH
            const cocokSearch =
                rowText.includes(keyword);


            // FILTER JENIS LAYANAN
            const cocokJenis =
                jenisLayanan === '' ||
                rowText.includes(jenisLayanan);


            // FILTER STATUS
            let cocokStatus = true;

            if (status === 'belum') {

                cocokStatus =
                    rowText.includes('belum');

            }

            if (status === 'final') {

                cocokStatus =
                    rowText.includes('final');

            }


            // TAMPILKAN / SEMBUNYIKAN ROW
            if (
                cocokSearch &&
                cocokJenis &&
                cocokStatus
            ) {

                row.style.display = '';

            } else {

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
    // FILTER JENIS LAYANAN
    // ==========================================

    filterJenisLayanan.addEventListener(
        'change',
        applyFilter
    );


    // ==========================================
    // RESET FILTER
    // ==========================================

    resetFilter.addEventListener('click', function () {

        searchInput.value = '';

        filterStatus.value = '';

        filterJenisLayanan.value = '';

        applyFilter();

    });

});
</script>
@endpush