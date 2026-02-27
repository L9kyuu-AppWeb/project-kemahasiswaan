<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanReferal extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_beasiswa_id',
        'nama',
        'no_telp',
        'program_studi',
    ];

    public function laporanBeasiswa()
    {
        return $this->belongsTo(LaporanBeasiswa::class);
    }
}
