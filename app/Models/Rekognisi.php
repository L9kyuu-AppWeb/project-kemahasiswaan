<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekognisi extends Model
{
    use HasFactory;

    protected $table = 'rekognisi';

    protected $fillable = [
        'nama_rekognisi',
        'jenis_rekognisi_id',
        'nama_penyelenggara',
        'url_rekognisi',
        'dokumen_sertifikat',
        'foto_kegiatan',
        'dokumen_bukti',
        'surat_tugas',
        'tanggal_sertifikat',
        'mahasiswa_id',
        'dosen_id',
        'status',
        'keterangan_verifikasi',
        'jenis_kegiatan_id',
        'detail_kegiatan_id',
        'ruang_lingkup_id',
        'nilai',
    ];

    protected $casts = [
        'tanggal_sertifikat' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function jenisRekognisi()
    {
        return $this->belongsTo(JenisRekognisi::class);
    }

    public function jenisKegiatan()
    {
        return $this->belongsTo(JenisKegiatan::class, 'jenis_kegiatan_id');
    }

    public function detailKegiatan()
    {
        return $this->belongsTo(DetailKegiatan::class, 'detail_kegiatan_id');
    }

    public function ruangLingkup()
    {
        return $this->belongsTo(RuangLingkup::class, 'ruang_lingkup_id');
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
