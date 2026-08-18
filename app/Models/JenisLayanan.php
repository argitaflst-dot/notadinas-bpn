<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seksi;
use App\Models\Berkas;

class JenisLayanan extends Model
{
    use HasFactory;

    protected $table = 'jenis_layanan';

    protected $fillable = [
        'seksi_id',
        'nama_layanan',
    ];

    public function seksi()
    {
        return $this->belongsTo(Seksi::class);
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class);
    }
}