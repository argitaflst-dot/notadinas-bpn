<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table = 'berkas';

    protected $fillable = [
        'jenis_layanan_id',
        'no_berkas',
        'tanggal_pendaftaran',
        'no_hak',
        'nib_elektronik',
        'pemohon',
        'tempat_lahir',
        'tanggal_lahir',
        'nomor_akta',
        'tanggal_akta',
        'ppat',
        'desa_kelurahan',
        'kecamatan',
        'luas',
        'keterangan',
    ];

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class);
    }
}