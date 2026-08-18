<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JenisLayanan;

class Seksi extends Model
{
    use HasFactory;

    protected $table = 'seksi';

    protected $fillable = [
        'nama_seksi',
    ];

    public function jenisLayanan()
    {
        return $this->hasMany(JenisLayanan::class);
    }
}