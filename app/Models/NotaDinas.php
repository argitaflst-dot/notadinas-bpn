<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Berkas;

class NotaDinas extends Model
{
    protected $table = 'nota_dinas';

    protected $fillable = [
        'nomor',
        'tahun',
        'kepada',
        'dari',
        'tanggal',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tahun' => 'integer',
    ];

    public function berkas()
    {
        return $this->belongsToMany(
            Berkas::class,
            'nota_dinas_berkas',
            'nota_dinas_id',
            'berkas_id',
            'id',
            'id_berkas'
        );
    }
}