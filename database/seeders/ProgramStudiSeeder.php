<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProgramStudi::create([
            'kode' => 'TI',
            'nama' => 'Teknik Informatika',
            'singkatan' => 'TIF',
            'deskripsi' => 'Program studi yang mempelajari tentang teknologi informasi dan komputer.',
        ]);

        ProgramStudi::create([
            'kode' => 'SI',
            'nama' => 'Sistem Informasi',
            'singkatan' => 'SIF',
            'deskripsi' => 'Program studi yang mempelajari tentang pengelolaan sistem informasi.',
        ]);

        ProgramStudi::create([
            'kode' => 'TK',
            'nama' => 'Teknik Komputer',
            'singkatan' => 'TK',
            'deskripsi' => 'Program studi yang mempelajari tentang hardware dan software komputer.',
        ]);

        ProgramStudi::create([
            'kode' => 'AK',
            'nama' => 'Akuntansi',
            'singkatan' => 'AKT',
            'deskripsi' => 'Program studi yang mempelajari tentang akuntansi dan keuangan.',
        ]);

        ProgramStudi::create([
            'kode' => 'MN',
            'nama' => 'Manajemen',
            'singkatan' => 'MNJ',
            'deskripsi' => 'Program studi yang mempelajari tentang manajemen bisnis.',
        ]);
    }
}
