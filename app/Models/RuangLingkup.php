<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangLingkup extends Model
{
    use HasFactory;

    protected $table = 'ruang_lingkup';
    protected $fillable = ['nama'];

    public function nilaiKegiatans()
    {
        return $this->hasMany(NilaiKegiatan::class, 'ruang_id');
    }
}
