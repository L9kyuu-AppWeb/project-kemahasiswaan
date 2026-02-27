<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogKegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_magang_id',
        'tanggal',
        'uraian_kegiatan',
        'hasil_kegiatan',
        'kendala',
        'jam_mulai',
        'jam_selesai',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function laporanMagang()
    {
        return $this->belongsTo(LaporanMagang::class);
    }

    public function buktiKegiatans()
    {
        return $this->hasMany(BuktiKegiatan::class);
    }
}
