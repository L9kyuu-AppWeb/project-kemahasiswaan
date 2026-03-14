<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriKegiatanUmum;

class KategoriKegiatanUmumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriData = [
            ['id' => 1, 'nama_kategori' => 'Seminar'],
            ['id' => 2, 'nama_kategori' => 'Organisasi'],
            ['id' => 3, 'nama_kategori' => 'Lomba'],
            ['id' => 4, 'nama_kategori' => 'Workshop'],
            ['id' => 5, 'nama_kategori' => 'Pelatihan'],
            ['id' => 6, 'nama_kategori' => 'Konferensi'],
            ['id' => 7, 'nama_kategori' => 'Pengabdian Masyarakat'],
            ['id' => 8, 'nama_kategori' => 'Penelitian'],
        ];

        foreach ($kategoriData as $data) {
            KategoriKegiatanUmum::updateOrCreate(
                ['id' => $data['id']],
                ['nama_kategori' => $data['nama_kategori']]
            );
        }

        $this->command->info('Kategori kegiatan umum data seeded successfully!');
    }
}
