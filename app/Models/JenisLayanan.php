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
    protected $primaryKey = 'id_jenis_layanan';

    protected $fillable = [
        'id_seksi',
        'nama_layanan',
    ];

    public function seksi()
    {
        return $this->belongsTo(Seksi::class, 'id_seksi', 'id_seksi');
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class, 'id_jenis_layanan', 'id_jenis_layanan');
    }
}