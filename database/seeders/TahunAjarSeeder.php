<?php

namespace Database\Seeders;

use App\Models\TahunAjar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunAjarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjarData = [
            ['nama' => '2023/2024 Ganjil', 'tahun_mulai' => '2023', 'tahun_selesai' => '2024', 'semester' => 'ganjil', 'is_active' => false],
            ['nama' => '2023/2024 Genap', 'tahun_mulai' => '2023', 'tahun_selesai' => '2024', 'semester' => 'genap', 'is_active' => false],
            ['nama' => '2024/2025 Ganjil', 'tahun_mulai' => '2024', 'tahun_selesai' => '2025', 'semester' => 'ganjil', 'is_active' => true],
            ['nama' => '2024/2025 Genap', 'tahun_mulai' => '2024', 'tahun_selesai' => '2025', 'semester' => 'genap', 'is_active' => false],
            ['nama' => '2025/2026 Ganjil', 'tahun_mulai' => '2025', 'tahun_selesai' => '2026', 'semester' => 'ganjil', 'is_active' => false],
            ['nama' => '2025/2026 Genap', 'tahun_mulai' => '2025', 'tahun_selesai' => '2026', 'semester' => 'genap', 'is_active' => false],
        ];

        foreach ($tahunAjarData as $data) {
            TahunAjar::create($data);
        }
    }
}
