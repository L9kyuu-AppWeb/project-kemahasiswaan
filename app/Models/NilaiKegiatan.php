<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKegiatan extends Model
{
    use HasFactory;

    protected $table = 'nilai_kegiatan';
    protected $fillable = ['jenis_id', 'detail_id', 'ruang_id', 'nilai'];

    public function jenisKegiatan()
    {
        return $this->belongsTo(JenisKegiatan::class, 'jenis_id');
    }

    public function detailKegiatan()
    {
        return $this->belongsTo(DetailKegiatan::class, 'detail_id');
    }

    public function ruangLingkup()
    {
        return $this->belongsTo(RuangLingkup::class, 'ruang_id');
    }
}
