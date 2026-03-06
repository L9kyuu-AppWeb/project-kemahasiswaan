<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisRekognisi extends Model
{
    use HasFactory;

    protected $table = 'jenis_rekognisi';
    protected $fillable = ['nama'];
}
