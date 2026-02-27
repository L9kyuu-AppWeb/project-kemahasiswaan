<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkademik extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_beasiswa_id',
        'sks',
        'indeks_prestasi',
        'file_khs',
    ];

    public function laporanBeasiswa()
    {
        return $this->belongsTo(LaporanBeasiswa::class);
    }
}
