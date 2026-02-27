<?php

namespace Database\Seeders;

use App\Models\BeasiswaTipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeasiswaTipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BeasiswaTipe::create([
            'nama' => 'Kartu Indonesia Pintar',
            'kode' => 'KIP',
            'keterangan' => 'Beasiswa untuk mahasiswa penerima Kartu Indonesia Pintar',
            'status' => 'aktif',
        ]);

        BeasiswaTipe::create([
            'nama' => 'Peningkatan Prestasi Akademik',
            'kode' => 'PPA',
            'keterangan' => 'Beasiswa untuk mahasiswa dengan prestasi akademik tinggi',
            'status' => 'aktif',
        ]);

        BeasiswaTipe::create([
            'nama' => 'Bidikmisi',
            'kode' => 'BIDIKMISI',
            'keterangan' => 'Beasiswa untuk mahasiswa kurang mampu secara ekonomi',
            'status' => 'aktif',
        ]);

        BeasiswaTipe::create([
            'nama' => 'Beasiswa Bank Indonesia',
            'kode' => 'BBI',
            'keterangan' => 'Beasiswa dari Bank Indonesia untuk mahasiswa berprestasi',
            'status' => 'aktif',
        ]);

        BeasiswaTipe::create([
            'nama' => 'Beasiswa Djarum',
            'kode' => 'DJARUM',
            'keterangan' => 'Beasiswa dari Djarum Foundation',
            'status' => 'aktif',
        ]);

        BeasiswaTipe::create([
            'nama' => 'Beasiswa Unggulan',
            'kode' => 'BU',
            'keterangan' => 'Beasiswa unggulan dari Kementerian Pendidikan',
            'status' => 'tidak_aktif',
        ]);
    }
}
