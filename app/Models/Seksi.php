<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JenisLayanan;
use App\Models\Berkas;

class Seksi extends Model
{
    protected $table = 'seksi';

    protected $primaryKey = 'id_seksi';

    protected $fillable = [
        'nama_seksi',
        'nama_koordinator',
        'nip_koordinator',
    ];

    public function jenisLayanan()
    {
        return $this->hasMany(
            JenisLayanan::class,
            'id_seksi',
            'id_seksi'
        );
    }

    public function berkas()
    {
        return $this->hasMany(
            Berkas::class,
            'id_seksi',
            'id_seksi'
        );
    }
}