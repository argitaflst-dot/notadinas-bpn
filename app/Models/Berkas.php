<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JenisLayanan;

class Berkas extends Model
{
    protected $table = 'berkas';

    public function getIdBerkasAttribute()
    {
        return $this->attributes['id'];
    }

    public function getNamaPemohonAttribute()
    {
        return $this->attributes['pemohon'];
    }

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
        'status',
    ];

    protected $casts = [
        'tanggal_pendaftaran' => 'date',
        'tanggal_lahir' => 'date',
        'tanggal_akta' => 'date',
        'luas' => 'decimal:2',
    ];

    public function jenisLayanan()
    {
        return $this->belongsTo(
            JenisLayanan::class,
            'jenis_layanan_id',
            'id'
        );
    }
}