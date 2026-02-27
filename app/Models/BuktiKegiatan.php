<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiKegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_kegiatan_id',
        'file_bukti',
        'file_name',
        'file_type',
        'file_size',
    ];

    public function logKegiatan()
    {
        return $this->belongsTo(LogKegiatan::class);
    }
}
