<?php

namespace Database\Seeders;

use App\Models\Seksi;
use Illuminate\Database\Seeder;

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
            Seksi::firstOrCreate([
                'nama_seksi' => $nama,
            ]);
        }
    }
}
