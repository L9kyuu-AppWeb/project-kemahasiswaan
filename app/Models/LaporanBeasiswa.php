<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanBeasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'beasiswa_tipe_id',
        'tahun_ajar_id',
        'semester',
        'status',
        'catatan_admin',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function beasiswaTipe()
    {
        return $this->belongsTo(BeasiswaTipe::class);
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }

    public function laporanAkademik()
    {
        return $this->hasOne(LaporanAkademik::class);
    }

    public function laporanReferals()
    {
        return $this->hasMany(LaporanReferal::class);
    }

    public function laporanPendanaans()
    {
        return $this->hasMany(LaporanPendanaan::class);
    }

    public function laporanKompetisis()
    {
        return $this->hasMany(LaporanKompetisi::class);
    }

    public function laporanPublikasis()
    {
        return $this->hasMany(LaporanPublikasi::class);
    }
}
