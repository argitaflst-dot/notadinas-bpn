@extends('layouts.app')

@section('title', 'Input Berkas')

@section('content')

    <div class="bg-white rounded-lg shadow-sm p-6">

        {{-- Judul --}}
        <div class="mb-6">
            <h1 class="text-lg font-bold text-gray-800">Input berkas baru</h1>
            <p class="text-sm text-gray-500">Masukkan data berkas sesuai kolom pada nota dinas</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 text-red-700 text-sm px-4 py-3">
                <p class="font-semibold mb-1">Ada input yang perlu diperbaiki:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('berkas.store') }}" method="POST">
            @csrf

            {{-- ===================== SECTION 1: Seksi & Jenis Layanan ===================== --}}
            <div class="border border-gray-200 rounded-lg p-5 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-[#003B7A]">🏠</span>
                    <h2 class="font-semibold text-gray-700 text-sm">Seksi &amp; jenis layanan</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="id_seksi" class="block text-sm text-gray-600 mb-1">Sub seksi</label>
                        <select
                            id="id_seksi"
                            name="id_seksi"
                            required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                            <option value="">-- Pilih sub seksi --</option>
                            @foreach ($seksiList as $seksi)
                                <option value="{{ $seksi->id_seksi }}" {{ old('id_seksi') == $seksi->id_seksi ? 'selected' : '' }}>
                                    {{ $seksi->nama_seksi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="id_jenis_layanan" class="block text-sm text-gray-600 mb-1">Jenis layanan</label>
                        <select
                            id="id_jenis_layanan"
                            name="id_jenis_layanan"
                            required
                            disabled
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A] disabled:bg-gray-100">
                            <option value="">-- Pilih sub seksi dahulu --</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ===================== SECTION 2: Data Berkas ===================== --}}
            <div class="border border-gray-200 rounded-lg p-5 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-[#003B7A]">📋</span>
                    <h2 class="font-semibold text-gray-700 text-sm">Data berkas</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="no_berkas" class="block text-sm text-gray-600 mb-1">No. berkas</label>
                        <input type="text" id="no_berkas" name="no_berkas" value="{{ old('no_berkas') }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                    <div>
                        <label for="tanggal_pendaftaran" class="block text-sm text-gray-600 mb-1">Tanggal Pendaftaran</label>
                        <input type="date" id="tanggal_pendaftaran" name="tanggal_pendaftaran" value="{{ old('tanggal_pendaftaran') }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="no_hak" class="block text-sm text-gray-600 mb-1">NO HAK</label>
                        <input type="text" id="no_hak" name="no_hak" value="{{ old('no_hak') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                    <div>
                        <label for="nib_elektronik" class="block text-sm text-gray-600 mb-1">NIB elektronik</label>
                        <input type="text" id="nib_elektronik" name="nib_elektronik" value="{{ old('nib_elektronik') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                </div>
            </div>

            {{-- ===================== SECTION 3: Data Pemohon ===================== --}}
            <div class="border border-gray-200 rounded-lg p-5 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-[#003B7A]">👤</span>
                    <h2 class="font-semibold text-gray-700 text-sm">Data pemohon</h2>
                </div>

                <div class="mb-6">
                    <label for="nama_pemohon" class="block text-sm text-gray-600 mb-1">Nama pemohon</label>
                    <input type="text" id="nama_pemohon" name="nama_pemohon" value="{{ old('nama_pemohon') }}" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tempat_lahir" class="block text-sm text-gray-600 mb-1">Tempat lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-sm text-gray-600 mb-1">Tanggal lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                </div>
            </div>

            {{-- ===================== SECTION 4: Data Akta & Notasi Tanah ===================== --}}
            <div class="border border-gray-200 rounded-lg p-5 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-[#003B7A]">📄</span>
                    <h2 class="font-semibold text-gray-700 text-sm">Data akta &amp; notasi tanah</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nomor_akta" class="block text-sm text-gray-600 mb-1">Nomor akta</label>
                        <input type="text" id="nomor_akta" name="nomor_akta" value="{{ old('nomor_akta') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                    <div>
                        <label for="tanggal_akta" class="block text-sm text-gray-600 mb-1">Tanggal akta</label>
                        <input type="date" id="tanggal_akta" name="tanggal_akta" value="{{ old('tanggal_akta') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="ppat" class="block text-sm text-gray-600 mb-1">PPAT</label>
                        <input type="text" id="ppat" name="ppat" value="{{ old('ppat') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                    <div>
                        <label for="desa_kelurahan" class="block text-sm text-gray-600 mb-1">Desa/kelurahan</label>
                        <input type="text" id="desa_kelurahan" name="desa_kelurahan" value="{{ old('desa_kelurahan') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                    <div>
                        <label for="kecamatan" class="block text-sm text-gray-600 mb-1">Kecamatan</label>
                        <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="luas" class="block text-sm text-gray-600 mb-1">Luas (m&sup2;)</label>
                        <input type="number" step="0.01" id="luas" name="luas" value="{{ old('luas') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                    <div>
                        <label for="nib_elektronik_akta" class="block text-sm text-gray-600 mb-1">NIB elektronik</label>
                        <input type="text" id="nib_elektronik_akta" name="nib_elektronik_akta" value="{{ old('nib_elektronik_akta') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#003B7A]">
                    </div>
                </div>
            </div>

            {{-- Tombol aksi --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('berkas.create') }}"
                   class="px-4 py-2 text-sm rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 text-sm rounded-md bg-[#003B7A] text-white font-medium hover:bg-[#002e5f]">
                    Simpan Berkas
                </button>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seksiSelect = document.getElementById('id_seksi');
        const jenisSelect = document.getElementById('id_jenis_layanan');

        seksiSelect.addEventListener('change', function () {
            const seksiId = this.value;

            jenisSelect.innerHTML = '<option value="">Memuat...</option>';
            jenisSelect.disabled = true;

            if (!seksiId) {
                jenisSelect.innerHTML = '<option value="">-- Pilih sub seksi dahulu --</option>';
                return;
            }

            fetch(`/jenis-layanan/${seksiId}`, {
                headers: { 'Accept': 'application/json' }
            })
                .then(res => {
                    if (!res.ok) throw new Error('Gagal mengambil data jenis layanan');
                    return res.json();
                })
                .then(data => {
                    jenisSelect.innerHTML = '<option value="">-- Pilih jenis layanan --</option>';

                    if (data.length === 0) {
                        jenisSelect.innerHTML = '<option value="">Tidak ada jenis layanan untuk seksi ini</option>';
                        return;
                    }

                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.id_jenis_layanan;
                        opt.textContent = item.nama_layanan;
                        jenisSelect.appendChild(opt);
                    });

                    jenisSelect.disabled = false;
                })
                .catch(err => {
                    jenisSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                    console.error(err);
                });
        });
    });
</script>
@endpush