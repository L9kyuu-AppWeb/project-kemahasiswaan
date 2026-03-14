<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanUmum extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_umums';
    
    protected $fillable = [
        'kategori',
        'jenis_kegiatan_id',
        'detail_kegiatan_id',
        'ruang_lingkup_id',
        'nilai',
        'nama_kompetisi',
        'penyelenggara',
        'url_kegiatan',
        'dokumen_sertifikat',
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
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
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
}
