<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tahun_mulai',
        'tahun_selesai',
        'semester',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function laporanBeasiswas()
    {
        return $this->hasMany(LaporanBeasiswa::class);
    }
}
