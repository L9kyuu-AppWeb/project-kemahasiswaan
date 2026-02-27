<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMagang extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_magang_id',
        'mahasiswa_id',
        'tahun_ajar_id',
        'judul_laporan',
        'deskripsi',
        'tanggal_kegiatan',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi_kegiatan',
        'status',
        'catatan_admin',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function mahasiswaMagang()
    {
        return $this->belongsTo(MahasiswaMagang::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }

    public function logKegiatans()
    {
        return $this->hasMany(LogKegiatan::class);
    }
}
