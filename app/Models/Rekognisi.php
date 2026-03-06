<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekognisi extends Model
{
    use HasFactory;

    protected $table = 'rekognisi';

    protected $fillable = [
        'level',
        'nama_rekognisi',
        'jenis_rekognisi_id',
        'nama_penyelenggara',
        'url_rekognisi',
        'dokumen_sertifikat',
        'foto_kegiatan',
        'dokumen_bukti',
        'surat_tugas',
        'tanggal_sertifikat',
        'nim',
        'nama_mahasiswa',
        'nidn_nuptk',
        'nama_dosen',
        'status',
        'keterangan_verifikasi',
    ];

    protected $casts = [
        'tanggal_sertifikat' => 'date',
    ];

    public function jenisRekognisi()
    {
        return $this->belongsTo(JenisRekognisi::class);
    }
}
