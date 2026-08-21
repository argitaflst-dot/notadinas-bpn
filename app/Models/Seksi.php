<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JenisLayanan;
use App\Models\Berkas;

class Seksi extends Model
{
    protected $table = 'seksi';

    public function getIdSeksiAttribute()
    {
        return $this->attributes['id'];
    }

    protected $fillable = [
        'nama_seksi',
    ];

    public function jenisLayanan()
    {
        return $this->hasMany(
            JenisLayanan::class,
            'seksi_id',
            'id'
        );
    }

    public function berkas()
    {
        return $this->hasMany(
            Berkas::class,
            'seksi_id',
            'id'
        );
    }
}