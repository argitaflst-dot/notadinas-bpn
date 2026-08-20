<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table = 'berkas';
    protected $primaryKey = 'id_berkas';

    protected $fillable = [
        'id_seksi',
        'id_jenis_layanan',

        // Data berkas
        'no_berkas',
        'tanggal_pendaftaran',
        'no_hak',
        'nib_elektronik',

        // Data pemohon
        'nama_pemohon',
        'tempat_lahir',
        'tanggal_lahir',

        // Data akta & notasi tanah
        'nomor_akta',
        'tanggal_akta',
        'ppat',
        'desa_kelurahan',
        'kecamatan',
        'luas',
        'nib_elektronik_akta',

        'status',
    ];

    protected $casts = [
        'tanggal_pendaftaran' => 'date',
        'tanggal_lahir'       => 'date',
        'tanggal_akta'        => 'date',
        'luas'                => 'decimal:2',
    ];

    public function seksi()
    {
        return $this->belongsTo(Seksi::class, 'id_seksi', 'id_seksi');
    }

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class, 'id_jenis_layanan', 'id_jenis_layanan');
    }
}