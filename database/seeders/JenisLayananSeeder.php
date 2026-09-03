<?php

namespace Database\Seeders;

use App\Models\JenisLayanan;
use App\Models\Seksi;
use Illuminate\Database\Seeder;

class JenisLayananSeeder extends Seeder
{
    public function run(): void
    {
        $seksi1 = Seksi::where(
            'nama_seksi',
            'Pendaftaran Tanah dan Ruang, Tanah Komunal dan Hubungan Kelembagaan'
        )->first();

        $seksi2 = Seksi::where(
            'nama_seksi',
            'Penetapan Hak Tanah dan Ruang'
        )->first();

        $seksi3 = Seksi::where(
            'nama_seksi',
            'Penetapan dan Pengelolaan Tanah Pemerintah'
        )->first();

        $seksi4 = Seksi::where(
            'nama_seksi',
            'Pemeliharaan Hak Tanah, Ruang dan Pembinaan PPAT'
        )->first();

        // Seksi 1
        $layananSeksi1 = [
            'Hapusnya Hak',
            'Pendaftaran SK Hak',
            'Pendaftaran SK Perpanjangan/Pembaruan Hak',
            'Pendaftaran Tanah Pertama Kali Pengakuan/Penegasan Hak',
            'Pendaftaran Tanah Pertama Kali Pengakuan/Penegasan Hak Wakaf',
            'Pendaftaran Tanah Pertama Kali Wakaf untuk Tanah Yang Belum Sertipikat (Tanah Adat)',
            'Pendaftaran Tanah Pertama Kali Wakaf untuk Tanah Yang Belum Sertipikat (Tanah Negara)',
            'Roya',
            'Sertipikat Hak Tanggungan Pengganti Karena Hilang',
            'Sertipikat Pengganti Karena Blanko Lama',
            'Sertipikat Pengganti Karena Hilang',
            'Sertipikat Pengganti Karena Rusak',
            'Wakaf dari Tanah Yang Sudah Bersertipikat',
        ];

        foreach ($layananSeksi1 as $nama) {
            JenisLayanan::firstOrCreate([
                'seksi_id' => $seksi1->id,
                'nama_layanan' => $nama,
            ]);
        }

        // Seksi 2
        $layananSeksi2 = [
            'Permohonan SK Pemberian HGB Badan Hukum Untuk Pembangunan Rumah MBR',
            'Permohonan SK Pemberian HGB/HP di atas HPL',
            'Permohonan SK Perpanjangan Hak Guna Bangunan Badan Hukum',
            'Permohonan SK Perpanjangan Hak Guna Bangunan Perorangan',
            'Permohonan SK Perpanjangan Hak Pakai Badan Hukum',
            'Permohonan SK Perpanjangan/Pembaruan HGB diatas HPL Badan Hukum',
        ];

        foreach ($layananSeksi2 as $nama) {
            JenisLayanan::firstOrCreate([
                'seksi_id' => $seksi2->id,
                'nama_layanan' => $nama,
            ]);
        }

        // Seksi 3
        $layananSeksi3 = [
            'Permohonan SK Pemberian Hak Guna Bangunan Instansi/Badan Usaha Pemerintah',
            'Permohonan SK Pemberian Hak Pakai Instansi/Badan Usaha Pemerintah',
            'Permohonan SK Pemberian Hak Pengelolaan Instansi/Badan Usaha Pemerintah',
        ];

        foreach ($layananSeksi3 as $nama) {
            JenisLayanan::firstOrCreate([
                'seksi_id' => $seksi3->id,
                'nama_layanan' => $nama,
            ]);
        }

        // Seksi 4
        $layananSeksi4 = [
            'Blokir',
            'Cassie',
            'Ganti Nama',
            'Ganti Nama Kreditor',
            'Ganti Nama Pemegang Hak Tanggungan',
            'Lelang Dengan Perubahan Hak',
            'Merger + Ganti Nama Pemegang Hak Tanggungan',
            'Merger Hak Tanggungan',
            'Merger Kreditor',
            'Pelantikan PPAT',
            'Pelepasan Sebagian Hak',
            'Pemecahan Bidang',
            'Pemisahan Bidang',
            'Penataan Batas',
            'Pencabutan Blokir',
            'Pencatatan Perubahan Penggunaan Tanah',
            'Pendaftaran Peralihan Dalam Rangka Pengampunan Pajak',
            'Pengangkatan Pertama Kali PPAT',
            'Pengangkatan Sita',
            'Penggabungan Bidang',
            'Peralihan Hak - Hibah',
            'Peralihan Hak - Jual Beli',
            'Peralihan Hak - Jual Beli (Tertentu)',
            'Peralihan Hak - Lelang',
            'Peralihan Hak - Pemasukan Ke Dalam Perusahaan',
            'Peralihan Hak - Pembagian Hak Bersama',
            'Peralihan Hak - Pemisahan Persero atau Koperasi',
            'Peralihan Hak - Pewarisan',
            'Peralihan Hak - Reorganisasi atau Restrukturisasi Perseroan',
            'Peralihan Hak - Tukar Menukar',
            'Perubahan Hak Atas Tanah',
            'Sita',
            'Perubahan Data Berdasarkan Penetapan atau Putusan Pengadilan',
            'Waris Dengan Perubahan Hak',
        ];

        foreach ($layananSeksi4 as $nama) {
            JenisLayanan::firstOrCreate([
                'seksi_id' => $seksi4->id,
                'nama_layanan' => $nama,
            ]);
        }
    }
}
