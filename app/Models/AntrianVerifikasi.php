<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AntrianVerifikasi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'deskripsi',
        'tanggal_mulai_pendaftaran',
        'tanggal_selesai_pendaftaran',
        'tanggal_mulai_verifikasi',
        'tanggal_selesai_verifikasi',
        'kuota_per_hari',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_mulai_pendaftaran' => 'date',
        'tanggal_selesai_pendaftaran' => 'date',
        'tanggal_mulai_verifikasi' => 'date',
        'tanggal_selesai_verifikasi' => 'date',
        'kuota_per_hari' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get all details (registrations) for this antrian verifikasi.
     */
    public function details(): HasMany
    {
        return $this->hasMany(AntrianVerifikasiDetail::class);
    }

    /**
     * Check if registration is currently open.
     */
    public function isPendaftaranOpen(): bool
    {
        $today = now()->toDateString();
        return $this->is_active
            && $today >= $this->tanggal_mulai_pendaftaran->toDateString()
            && $today <= $this->tanggal_selesai_pendaftaran->toDateString();
    }

    /**
     * Get available dates with remaining quota.
     */
    public function getAvailableDates(): array
    {
        $availableDates = [];
        $startDate = $this->tanggal_mulai_verifikasi;
        $endDate = $this->tanggal_selesai_verifikasi;
        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            // Skip weekends (Saturday = 6, Sunday = 0)
            if ($currentDate->format('N') < 6) {
                $counted = $this->details()
                    ->where('tanggal_verifikasi', $currentDate->toDateString())
                    ->where('status', '!=', 'dibatalkan')
                    ->count();

                if ($counted < $this->kuota_per_hari) {
                    $availableDates[] = [
                        'tanggal' => $currentDate->toDateString(),
                        'nama_hari' => $currentDate->translatedFormat('l, d F Y'),
                        'sisa_kuota' => $this->kuota_per_hari - $counted,
                    ];
                }
            }
            $currentDate->addDay();
        }

        return $availableDates;
    }
}
