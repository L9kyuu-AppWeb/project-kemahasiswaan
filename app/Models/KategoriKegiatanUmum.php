<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKegiatanUmum extends Model
{
    use HasFactory;

    protected $table = 'kategori_kegiatan_umums';
    
    protected $fillable = [
        'nama_kategori',
    ];
}
