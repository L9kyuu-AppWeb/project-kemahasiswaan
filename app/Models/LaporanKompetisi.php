<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKompetisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_beasiswa_id',
        'nama_kompetisi',
        'judul',
        'juara',
        'posisi',
        'file_bukti',
    ];

    public function laporanBeasiswa()
    {
        return $this->belongsTo(LaporanBeasiswa::class);
    }
}
