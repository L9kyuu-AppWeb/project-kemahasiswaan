<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AntrianVerifikasiDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'antrian_verifikasi_id',
        'mahasiswa_id',
        'tanggal_verifikasi',
        'jam_verifikasi',
        'nomor_antrian',
        'status',
        'hadir_verifikasi',
        'keterangan',
        'bukti_pdf_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_verifikasi' => 'date',
        'hadir_verifikasi' => 'boolean',
    ];

    /**
     * Get the antrian verifikasi that owns this detail.
     */
    public function antrianVerifikasi(): BelongsTo
    {
        return $this->belongsTo(AntrianVerifikasi::class);
    }

    /**
     * Get the mahasiswa that owns this detail.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Generate queue number for this registration.
     */
    public static function generateNomorAntrian($antrianVerifikasiId, $tanggalVerifikasi): string
    {
        $tanggal = is_string($tanggalVerifikasi) ? $tanggalVerifikasi : $tanggalVerifikasi->toDateString();
        
        $count = self::where('antrian_verifikasi_id', $antrianVerifikasiId)
            ->where('tanggal_verifikasi', $tanggal)
            ->where('status', '!=', 'dibatalkan')
            ->count();

        $tanggalObj = \Carbon\Carbon::parse($tanggal);
        $nomorUrut = $count + 1;
        
        return sprintf('AV/%s/%03d', $tanggalObj->format('dmY'), $nomorUrut);
    }
}
