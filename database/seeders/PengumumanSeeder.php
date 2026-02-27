<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengumuman::create([
            'judul' => 'Pendaftaran Beasiswa KIP Gelombang 1',
            'konten' => 'Pendaftaran beasiswa Kartu Indonesia Pintar (KIP) gelombang 1 telah dibuka. Silakan mendaftar melalui portal kemahasiswaan.',
            'kategori' => 'beasiswa',
            'prioritas' => 'tinggi',
            'is_published' => true,
            'tanggal_publish' => now()->subDays(5),
        ]);

        Pengumuman::create([
            'judul' => 'Jadwal Ujian Tengah Semester',
            'konten' => 'Ujian Tengah Semester (UTS) akan dilaksanakan pada minggu depan. Harap mempersiapkan diri dengan baik.',
            'kategori' => 'akademik',
            'prioritas' => 'sedang',
            'is_published' => true,
            'tanggal_publish' => now()->subDays(3),
        ]);

        Pengumuman::create([
            'judul' => 'Lomba Karya Tulis Ilmiah Nasional',
            'konten' => 'Unit Kegiatan Mahasiswa mengadakan Lomba Karya Tulis Ilmiah Nasional. Hadiah total 50 juta rupiah.',
            'kategori' => 'kemahasiswaan',
            'prioritas' => 'sedang',
            'is_published' => true,
            'tanggal_publish' => now()->subDays(1),
        ]);

        Pengumuman::create([
            'judul' => 'Workshop Pengembangan Diri',
            'konten' => 'Workshop pengembangan diri akan diadakan pada akhir bulan ini. Topik: Leadership dan Public Speaking.',
            'kategori' => 'kemahasiswaan',
            'prioritas' => 'rendah',
            'is_published' => true,
            'tanggal_publish' => now(),
        ]);
    }
}
