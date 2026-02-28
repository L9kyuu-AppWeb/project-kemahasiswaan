<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class MahasiswaImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows, SkipsOnFailure, SkipsOnError
{
    use SkipsFailures, SkipsErrors;

    /**
     * Get column value with multiple possible names
     */
    private function getColumnValue(array $row, array $possibleNames, $default = null)
    {
        foreach ($possibleNames as $name) {
            $normalizedName = $this->normalize($name);
            if (isset($row[$normalizedName]) && $row[$normalizedName] !== null && $row[$normalizedName] !== '') {
                return $row[$normalizedName];
            }
        }
        return $default;
    }

    /**
     * Normalize header name to snake_case
     */
    private function normalize($value)
    {
        return strtolower(str_replace(' ', '_', trim($value)));
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // WithHeadingRow converts headers to snake_case lowercase
        // "Nama Lengkap" -> "nama_lengkap", "Tahun Masuk" -> "tahun_masuk"
        
        $nim = $this->getColumnValue($row, ['nim', 'NIM']);
        $tahunMasuk = $this->getColumnValue($row, ['tahun_masuk', 'Tahun Masuk']);
        $programStudi = $this->getColumnValue($row, ['program_studi', 'Program Studi']);
        $name = $this->getColumnValue($row, ['nama_lengkap', 'Nama Lengkap', 'name', 'nama']);
        $email = $this->getColumnValue($row, ['email']);
        $password = $this->getColumnValue($row, ['password', 'Password'], 'password123');

        // Skip empty rows
        if (empty($nim) && empty($name) && empty($email)) {
            return null;
        }

        // Manual validation for required fields - throw exception with row info
        if (empty($nim)) {
            throw new \RuntimeException("NIM wajib diisi");
        }
        if (empty($tahunMasuk)) {
            throw new \RuntimeException("Tahun masuk wajib diisi");
        }
        if (empty($name)) {
            throw new \RuntimeException("Nama lengkap wajib diisi");
        }
        if (empty($email)) {
            throw new \RuntimeException("Email wajib diisi");
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException("Format email tidak valid: " . $email);
        }

        // Find program studi by name or code
        $programStudiModel = null;
        if (!empty($programStudi)) {
            $programStudiModel = ProgramStudi::where('nama', $programStudi)
                ->orWhere('kode', $programStudi)
                ->orWhere('singkatan', $programStudi)
                ->first();
        }

        // Check if NIM already exists
        if (Mahasiswa::where('nim', trim((string) $nim))->exists()) {
            return null; // Skip duplicate NIM
        }

        // Check if email already exists
        if (Mahasiswa::where('email', trim((string) $email))->exists()) {
            return null; // Skip duplicate email
        }

        return new Mahasiswa([
            'nim' => trim((string) $nim),
            'tahun_masuk' => trim((string) $tahunMasuk),
            'program_studi_id' => $programStudiModel?->id ?? null,
            'name' => trim((string) $name),
            'email' => trim((string) $email),
            'password' => Hash::make($password),
        ]);
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Handle failures
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failures[] = $failure;
        }
    }

    /**
     * Handle errors
     */
    public function onError(Throwable $e)
    {
        throw $e;
    }
}
