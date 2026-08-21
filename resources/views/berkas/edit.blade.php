@extends('layouts.app')

@section('title', 'Edit Berkas')

@section('content')
    @php
        $seksiId = old('id_seksi', $berkas->jenisLayanan->seksi_id);
        $jenisLayananId = old('id_jenis_layanan', $berkas->jenis_layanan_id);
    @endphp

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="mb-6">
            <h1 class="text-lg font-bold text-gray-800">Edit berkas</h1>
            <p class="text-sm text-gray-500">Perbarui data berkas sesuai kebutuhan.</p>
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

        <form action="{{ route('berkas.update', $berkas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="border border-gray-200 rounded-lg p-5 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <iconify-icon icon="material-symbols:home-work-outline-rounded" width="22" height="22" class="text-[#003B7A]"></iconify-icon>
                    <h2 class="font-semibold text-gray-700 text-sm">Seksi &amp; Jenis layanan</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="id_seksi" class="block text-sm text-gray-600 mb-1">Sub Seksi</label>
                        <select id="id_seksi" name="id_seksi" required class="searchable-select w-full">
                            <option value="">-- Pilih sub seksi --</option>
                            @foreach ($seksiList as $seksi)
                                <option value="{{ $seksi->id_seksi }}" {{ $seksiId == $seksi->id_seksi ? 'selected' : '' }}>
                                    {{ $seksi->nama_seksi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="id_jenis_layanan" class="block text-sm text-gray-600 mb-1">Jenis Layanan</label>
                        <select id="id_jenis_layanan" name="id_jenis_layanan" required class="searchable-select w-full">
                            <option value="">-- Pilih sub seksi dahulu --</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-5 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <iconify-icon icon="material-symbols:data-table-outline-rounded" width="22" height="22" class="text-[#003B7A]"></iconify-icon>
                    <h2 class="font-semibold text-gray-700 text-sm">Data Berkas</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="no_berkas" class="block text-sm text-gray-600 mb-1">No. Berkas</label>
                        <input type="text" id="no_berkas" name="no_berkas" value="{{ old('no_berkas', $berkas->no_berkas) }}" required class="form-input">
                    </div>
                    <div>
                        <label for="tanggal_pendaftaran" class="block text-sm text-gray-600 mb-1">Tanggal Pendaftaran</label>
                        <input type="date" id="tanggal_pendaftaran" name="tanggal_pendaftaran" value="{{ old('tanggal_pendaftaran', optional($berkas->tanggal_pendaftaran)->format('Y-m-d')) }}" required class="form-input">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="no_hak" class="block text-sm text-gray-600 mb-1">NO HAK</label>
                        <input type="text" id="no_hak" name="no_hak" value="{{ old('no_hak', $berkas->no_hak) }}" class="form-input">
                    </div>
                    <div>
                        <label for="nib_elektronik" class="block text-sm text-gray-600 mb-1">NIB Elektronik</label>
                        <input type="text" id="nib_elektronik" name="nib_elektronik" value="{{ old('nib_elektronik', $berkas->nib_elektronik) }}" class="form-input">
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-5 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <iconify-icon icon="octicon:person-24" width="22" height="22" class="text-[#003B7A]"></iconify-icon>
                    <h2 class="font-semibold text-gray-700 text-sm">Data Pemohon</h2>
                </div>
                <div class="mb-6">
                    <label for="nama_pemohon" class="block text-sm text-gray-600 mb-1">Nama Pemohon</label>
                    <input type="text" id="nama_pemohon" name="nama_pemohon" value="{{ old('nama_pemohon', $berkas->pemohon) }}" required class="form-input">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tempat_lahir" class="block text-sm text-gray-600 mb-1">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $berkas->tempat_lahir) }}" class="form-input">
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-sm text-gray-600 mb-1">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($berkas->tanggal_lahir)->format('Y-m-d')) }}" class="form-input">
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-5 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <iconify-icon icon="boxicons:file-star-filled" width="22" height="22" class="text-[#003B7A]"></iconify-icon>
                    <h2 class="font-semibold text-gray-700 text-sm">Data Akta &amp; Notasi Tanah</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nomor_akta" class="block text-sm text-gray-600 mb-1">Nomor Akta</label>
                        <input type="text" id="nomor_akta" name="nomor_akta" value="{{ old('nomor_akta', $berkas->nomor_akta) }}" class="form-input">
                    </div>
                    <div>
                        <label for="tanggal_akta" class="block text-sm text-gray-600 mb-1">Tanggal Akta</label>
                        <input type="date" id="tanggal_akta" name="tanggal_akta" value="{{ old('tanggal_akta', optional($berkas->tanggal_akta)->format('Y-m-d')) }}" class="form-input">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="ppat" class="block text-sm text-gray-600 mb-1">PPAT</label>
                        <input type="text" id="ppat" name="ppat" value="{{ old('ppat', $berkas->ppat) }}" class="form-input">
                    </div>
                    <div>
                        <label for="desa_kelurahan" class="block text-sm text-gray-600 mb-1">Desa/Kelurahan</label>
                        <input type="text" id="desa_kelurahan" name="desa_kelurahan" value="{{ old('desa_kelurahan', $berkas->desa_kelurahan) }}" class="form-input">
                    </div>
                    <div>
                        <label for="kecamatan" class="block text-sm text-gray-600 mb-1">Kecamatan</label>
                        <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $berkas->kecamatan) }}" class="form-input">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="luas" class="block text-sm text-gray-600 mb-1">Luas (m²)</label>
                        <input type="number" step="0.01" id="luas" name="luas" value="{{ old('luas', $berkas->luas) }}" class="form-input">
                    </div>
                    <div>
                        <label for="keterangan" class="block text-sm text-gray-600 mb-1">Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan', $berkas->keterangan) }}" class="form-input">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('berkas.pilih') }}" class="px-4 py-2 text-sm rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="px-5 py-2 text-sm rounded-md bg-[#003B7A] text-white font-medium hover:bg-[#002e5f] transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<style>
    .searchable-select { width: 100%; }
    .ts-wrapper { width: 100%; font-family: 'Inter', sans-serif; }
    .ts-control { min-height: 42px !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 8px 12px !important; box-shadow: none !important; font-size: 14px !important; background: white !important; }
    .ts-control.focus { border-color: #003B7A !important; box-shadow: 0 0 0 2px rgba(0, 59, 122, 0.15) !important; }
    .ts-dropdown { border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important; font-size: 14px !important; overflow: hidden; }
    .ts-dropdown .option { padding: 10px 12px !important; cursor: pointer; }
    .ts-dropdown .option:hover, .ts-dropdown .active { background: #eff6ff !important; color: #003B7A !important; }
    .ts-control input { font-size: 14px !important; }
</style>
@endpush

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const initialSeksi = @json($seksiId);
    const initialJenis = @json($jenisLayananId);
    const seksiSelect = new TomSelect('#id_seksi', {
        create: false,
        allowEmptyOption: true,
        placeholder: 'Cari atau pilih sub seksi...',
        searchField: ['text'],
        maxOptions: 100,
        closeAfterSelect: true,
        onChange: function (value) { loadJenisLayanan(value); }
    });
    const jenisSelect = new TomSelect('#id_jenis_layanan', {
        create: false,
        allowEmptyOption: true,
        placeholder: 'Pilih sub seksi dahulu...',
        searchField: ['text'],
        maxOptions: 100,
        closeAfterSelect: true,
        onInitialize: function () { this.disable(); }
    });
    function loadJenisLayanan(seksiId, selectedJenis = '') {
        if (!seksiId) {
            jenisSelect.clear();
            jenisSelect.clearOptions();
            jenisSelect.addOption({ value: '', text: '-- Pilih sub seksi dahulu --' });
            jenisSelect.disable();
            return;
        }
        jenisSelect.clear();
        jenisSelect.clearOptions();
        jenisSelect.addOption({ value: '', text: 'Memuat jenis layanan...' });
        jenisSelect.disable();
        fetch("{{ url('/jenis-layanan') }}/" + seksiId, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => { if (!response.ok) throw new Error('Gagal mengambil data jenis layanan.'); return response.json(); })
            .then(data => {
                jenisSelect.clear();
                jenisSelect.clearOptions();
                if (!data || data.length === 0) {
                    jenisSelect.addOption({ value: '', text: 'Tidak ada jenis layanan untuk seksi ini' });
                    jenisSelect.disable();
                    return;
                }
                data.forEach(item => jenisSelect.addOption({ value: item.id_jenis_layanan, text: item.nama_layanan }));
                jenisSelect.enable();
                if (selectedJenis) jenisSelect.setValue(String(selectedJenis));
            })
            .catch(() => {
                jenisSelect.clear();
                jenisSelect.clearOptions();
                jenisSelect.addOption({ value: '', text: 'Gagal memuat jenis layanan' });
                jenisSelect.disable();
            });
    }
    loadJenisLayanan(initialSeksi, initialJenis);
});
</script>
@endpush
