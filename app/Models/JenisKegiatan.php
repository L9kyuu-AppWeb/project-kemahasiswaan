<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKegiatan extends Model
{
    use HasFactory;

    protected $table = 'jenis_kegiatan';
    protected $fillable = ['nama'];

    public function detailKegiatans()
    {
        return $this->hasMany(DetailKegiatan::class, 'jenis_id');
    }

    public function nilaiKegiatans()
    {
        return $this->hasMany(NilaiKegiatan::class, 'jenis_id');
    }
}
