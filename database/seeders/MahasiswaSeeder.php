<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get program studi IDs
        $ti = \App\Models\ProgramStudi::where('kode', 'TI')->first();
        $si = \App\Models\ProgramStudi::where('kode', 'SI')->first();
        $tk = \App\Models\ProgramStudi::where('kode', 'TK')->first();
        $ak = \App\Models\ProgramStudi::where('kode', 'AK')->first();

        Mahasiswa::create([
            'nim' => '2024001',
            'tahun_masuk' => '2024',
            'program_studi_id' => $ti?->id,
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad.rizki@example.com',
            'password' => Hash::make('password123'),
        ]);

        Mahasiswa::create([
            'nim' => '2024002',
            'tahun_masuk' => '2024',
            'program_studi_id' => $si?->id,
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@example.com',
            'password' => Hash::make('password123'),
        ]);

        Mahasiswa::create([
            'nim' => '2023001',
            'tahun_masuk' => '2023',
            'program_studi_id' => $tk?->id,
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'password' => Hash::make('password123'),
        ]);

        Mahasiswa::create([
            'nim' => '2023002',
            'tahun_masuk' => '2023',
            'program_studi_id' => $ak?->id,
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
