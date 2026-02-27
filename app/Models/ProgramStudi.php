<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode',
        'nama',
        'singkatan',
        'deskripsi',
    ];

    /**
     * Get all mahasiswas in this program studi.
     */
    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
