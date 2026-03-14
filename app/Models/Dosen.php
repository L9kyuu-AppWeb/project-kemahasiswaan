<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens';

    protected $fillable = [
        'nuptk',
        'nama',
    ];

    public function kompetisiMahasiswaDosen()
    {
        return $this->hasMany(KompetisiMahasiswaDosen::class, 'nidn_nuptk', 'nuptk');
    }

    public function rekognisi()
    {
        return $this->hasMany(Rekognisi::class, 'nidn_nuptk', 'nuptk');
    }

    public function sertifikasi()
    {
        return $this->hasMany(Sertifikasi::class, 'nidn_nuptk', 'nuptk');
    }
}
