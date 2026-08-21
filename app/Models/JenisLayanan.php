<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Seksi;
use App\Models\Berkas;

class JenisLayanan extends Model
{
    protected $table = 'jenis_layanan';

    protected $fillable = [
        'seksi_id',
        'nama_layanan',
    ];

    public function seksi()
    {
        return $this->belongsTo(
            Seksi::class,
            'seksi_id',
            'id'
        );
    }

    public function berkas()
    {
        return $this->hasMany(
            Berkas::class,
            'jenis_layanan_id',
            'id'
        );
    }
}