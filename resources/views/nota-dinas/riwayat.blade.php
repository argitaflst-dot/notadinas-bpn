@extends('layouts.app')

@section('title', 'Riwayat')

@section('content')

    <div class="bg-white rounded-lg shadow-sm p-6">

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-lg font-bold text-gray-800">Riwayat nota dinas</h1>
            <p class="text-sm text-gray-500">Semua nota dinas yang sudah dibuat dan dikunci.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-md bg-green-50 text-green-700 text-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- SEARCH + FILTER --}}
        <div class="flex items-center gap-3 mb-4">

            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <iconify-icon icon="material-symbols:search" width="20" height="20"></iconify-icon>
                </span>
                <input
                    type="text"
                    id="searchRiwayat"
                    placeholder="Search..."
                    class="w-full h-10 pl-10 pr-4 rounded-md border border-gray-300 text-sm text-gray-700
                           placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#003B7A] focus:border-[#003B7A]">
            </div>

            <button
                type="button"
                id="btnFilter"
                class="h-10 px-4 flex items-center gap-2 rounded-md border border-gray-300 bg-white
                       text-gray-600 text-sm hover:bg-gray-50 transition">
                <iconify-icon icon="material-symbols:filter-list" width="20" height="20"></iconify-icon>
                <span>Filter</span>
            </button>

        </div>

        {{-- PANEL FILTER --}}
        <div id="filterPanel" class="hidden mb-4 p-4 rounded-md border border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Dari seksi</label>
                    <select id="filterSeksi"
                            class="w-full h-10 px-3 rounded-md border border-gray-300 bg-white text-sm text-gray-700
                                   focus:outline-none focus:ring-1 focus:ring-[#003B7A]">
                        <option value="">Semua Seksi</option>
                        @foreach ($seksiList as $item)
                            <option value="{{ strtolower(trim($item->nama_seksi)) }}">
                                {{ $item->nama_seksi }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="flex justify-end mt-3">
                <button type="button" id="resetFilter" class="text-sm text-gray-500 hover:text-[#003B7A]">
                    Reset Filter
                </button>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="w-full text-sm" id="tabelRiwayat">

                <thead class="bg-[#003B7A] text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">No. nota dinas</th>
                        <th class="px-4 py-3 text-left">Dari seksi</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-center">Jumlah berkas</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center"></th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($notaDinasList as $nota)

                        @php
                            $namaSeksi = $nota->berkas->first()?->seksi?->nama_seksi ?? '-';
                        @endphp

                        <tr data-seksi="{{ strtolower(trim($namaSeksi)) }}">

                            <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-700">
                                No. {{ $nota->nomor }} tahun {{ $nota->tahun }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $namaSeksi }}
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $nota->tanggal?->format('d/m/Y') ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $nota->berkas_count }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[#003B7A] text-white">
                                    Final
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('nota-dinas.preview', $nota) }}?print=1"
                                   target="_blank"
                                   title="Unduh / cetak PDF"
                                   class="text-black-600 hover:text-black-800 inline-flex">
                                    <iconify-icon icon="griddy-icons:pdf-download" width="22" height="22"></iconify-icon>
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                                Belum ada nota dinas yang difinalkan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const searchInput = document.getElementById('searchRiwayat');
        const btnFilter = document.getElementById('btnFilter');
        const filterPanel = document.getElementById('filterPanel');
        const filterSeksi = document.getElementById('filterSeksi');
        const resetFilter = document.getElementById('resetFilter');
        const rows = document.querySelectorAll('#tabelRiwayat tbody tr[data-seksi]');

        btnFilter.addEventListener('click', function () {
            filterPanel.classList.toggle('hidden');
        });

        function applyFilter() {
            const keyword = searchInput.value.toLowerCase().trim();
            const seksi = filterSeksi.value.toLowerCase().trim();

            rows.forEach(function (row) {
                const rowText = row.textContent.toLowerCase();
                const rowSeksi = (row.dataset.seksi || '').toLowerCase().trim();

                const cocokSearch = keyword === '' || rowText.includes(keyword);
                const cocokSeksi = seksi === '' || rowSeksi === seksi;

                row.style.display = (cocokSearch && cocokSeksi) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', applyFilter);
        filterSeksi.addEventListener('change', applyFilter);

        resetFilter.addEventListener('click', function () {
            searchInput.value = '';
            filterSeksi.value = '';
            applyFilter();
        });

    });
</script>
@endpush