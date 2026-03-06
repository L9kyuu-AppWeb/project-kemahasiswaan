<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    use HasFactory;

    protected $table = 'sertifikasi';

    protected $fillable = [
        'level',
        'nama_sertifikasi',
        'nama_penyelenggara',
        'url_sertifikasi',
        'dokumen_sertifikat',
        'foto_kegiatan',
        'dokumen_bukti',
        'tanggal_sertifikat',
        'nim',
        'nama_mahasiswa',
        'nidn_nuptk',
        'nama_dosen',
        'url_surat_tugas',
        'status',
        'keterangan_verifikasi',
    ];

    protected $casts = [
        'tanggal_sertifikat' => 'date',
    ];
}
