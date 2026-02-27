<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPublikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_beasiswa_id',
        'judul',
        'nama_tempat',
        'link_jurnal',
        'kategori',
    ];

    public function laporanBeasiswa()
    {
        return $this->belongsTo(LaporanBeasiswa::class);
    }
}
