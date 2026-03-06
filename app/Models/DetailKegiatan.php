<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKegiatan extends Model
{
    use HasFactory;

    protected $table = 'detail_kegiatan';
    protected $fillable = ['jenis_id', 'nama'];

    public function jenisKegiatan()
    {
        return $this->belongsTo(JenisKegiatan::class, 'jenis_id');
    }

    public function nilaiKegiatans()
    {
        return $this->hasMany(NilaiKegiatan::class, 'detail_id');
    }
}
