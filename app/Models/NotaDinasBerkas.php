<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaDinasBerkas extends Model
{
    protected $table = 'nota_dinas_berkas';

    protected $fillable = [
        'nota_dinas_id',
        'berkas_id',
    ];

    public function notaDinas()
    {
        return $this->belongsTo(
            NotaDinas::class,
            'nota_dinas_id',
            'id'
        );
    }

    public function berkas()
    {
        return $this->belongsTo(
            Berkas::class,
            'berkas_id',
            'id_berkas'
        );
    }
}
