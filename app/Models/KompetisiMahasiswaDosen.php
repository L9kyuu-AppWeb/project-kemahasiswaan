<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetisiMahasiswaDosen extends Model
{
    use HasFactory;

    protected $table = 'kompetisi_mahasiswa_dosen';

    protected $fillable = [
        'level_kegiatan',
        'kategori',
        'nama_kompetisi',
        'nama_cabang',
        'peringkat',
        'penyelenggara',
        'jumlah_pt_negara_peserta',
        'kepesertaan',
        'bentuk',
        'url_kompetisi',
        'dokumen_sertifikat',
        'tanggal_sertifikat',
        'foto_upp',
        'dokumen_undangan',
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
