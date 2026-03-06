<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LombaKategori extends Model
{
    use HasFactory;

    protected $table = 'lomba_kategori';
    protected $fillable = ['nama'];
}
