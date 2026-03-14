<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    use HasFactory;

    protected $table = 'sertifikasi';

    protected $fillable = [
        'nama_sertifikasi',
        'nama_penyelenggara',
        'url_sertifikasi',
        'dokumen_sertifikat',
        'foto_kegiatan',
        'dokumen_bukti',
        'tanggal_sertifikat',
        'mahasiswa_id',
        'dosen_id',
        'url_surat_tugas',
        'status',
        'keterangan_verifikasi',
    ];

    protected $casts = [
        'tanggal_sertifikat' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    /**
     * Get NIM through mahasiswa relationship
     */
    public function getNimAttribute()
    {
        return $this->mahasiswa ? $this->mahasiswa->nim : null;
    }

    /**
     * Get nama_mahasiswa through mahasiswa relationship
     */
    public function getNamaMahasiswaAttribute()
    {
        return $this->mahasiswa ? $this->mahasiswa->nama : null;
    }
}
