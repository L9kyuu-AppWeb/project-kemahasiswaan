<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeasiswaTipe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'kode',
        'keterangan',
        'status',
    ];

    /**
     * Get all mahasiswa beasiswa for this beasiswa tipe.
     */
    public function mahasiswaBeasiswas()
    {
        return $this->hasMany(MahasiswaBeasiswa::class);
    }
}
