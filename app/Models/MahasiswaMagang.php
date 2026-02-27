<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaMagang extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'tahun_ajar_id',
        'semester',
        'nama_perusahaan',
        'lokasi_perusahaan',
        'pembimbing_lapangan',
        'no_telp_pembimbing',
        'dosen_pembimbing_nama',
        'dosen_pembimbing_nik',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }

    public function laporanMagangs()
    {
        return $this->hasMany(LaporanMagang::class);
    }
}
