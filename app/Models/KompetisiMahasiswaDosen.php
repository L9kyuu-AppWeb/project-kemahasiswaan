<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetisiMahasiswaDosen extends Model
{
    use HasFactory;

    protected $table = 'kompetisi_mahasiswa_dosen';

    protected $fillable = [
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
        'mahasiswa_id',
        'dosen_id',
        'url_surat_tugas',
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
