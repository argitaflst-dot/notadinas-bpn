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

        <div class="flex items-center justify-between mb-4">
            <input type="text" id="searchBerkas" placeholder="Search..." class="form-input max-w-xs">
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

    document.querySelectorAll('.berkas-checkbox').forEach(cb => {
        cb.addEventListener('change', () => {
            counter.textContent = document.querySelectorAll('.berkas-checkbox:checked').length;
        });
    });

    document.getElementById('searchBerkas').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
        });
    });
});
</script>
@endpush