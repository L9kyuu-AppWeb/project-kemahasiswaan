<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaBeasiswa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mahasiswa_id',
        'beasiswa_tipe_id',
        'nomor_sk',
        'file_sk',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
        'alasan_tidak_aktif',
        'inactive_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'inactive_at' => 'datetime',
    ];

    /**
     * Get the mahasiswa for this beasiswa.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Get the beasiswa tipe for this beasiswa.
     */
    public function beasiswaTipe()
    {
        return $this->belongsTo(BeasiswaTipe::class);
    }

    /**
     * Get laporan beasiswa for this beasiswa record.
     */
    public function laporanBeasiswas()
    {
        return $this->hasMany(LaporanBeasiswa::class, 'beasiswa_tipe_id', 'beasiswa_tipe_id')
            ->where('mahasiswa_id', $this->mahasiswa_id);
    }
}
