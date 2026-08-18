<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seksi;

class SeksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seksi = [
            'Pendaftaran Tanah dan Ruang, Tanah Komunal dan Hubungan Kelembagaan',
            'Penetapan Hak Tanah dan Ruang',
            'Penetapan dan Pengelolaan Tanah Pemerintah',
            'Pemeliharaan Hak Tanah, Ruang dan Pembinaan PPAT',
        ];

        foreach ($seksi as $nama) {
            Seksi::create([
                'nama_seksi' => $nama
            ]);
        }
    }
}
