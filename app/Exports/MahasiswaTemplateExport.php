<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\Number;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaTemplateExport implements FromArray, WithHeadings, WithTitle
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [
            ['2024001', '2024', 'Teknik Informatika', 'Ahmad Rizki', 'ahmad.rizki@example.com', 'password123'],
            ['2024002', '2024', 'Sistem Informasi', 'Budi Santoso', 'budi.santoso@example.com', 'password123'],
            ['2024003', '2024', 'Manajemen', 'Citra Dewi', 'citra.dewi@example.com', 'password123'],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'NIM',
            'Tahun Masuk',
            'Program Studi',
            'Nama Lengkap',
            'Email',
            'Password (opsional)',
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Template Mahasiswa';
    }
}
