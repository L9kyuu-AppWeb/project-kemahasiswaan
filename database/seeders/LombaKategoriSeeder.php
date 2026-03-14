<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LombaKategori;

class LombaKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lombaKategoriData = [
            ['id' => 1, 'nama' => 'Riset & Inovasi'],
            ['id' => 2, 'nama' => 'Seni & Budaya'],
            ['id' => 3, 'nama' => 'Olahraga'],
        ];

        foreach ($lombaKategoriData as $data) {
            LombaKategori::updateOrCreate(
                ['id' => $data['id']],
                ['nama' => $data['nama']]
            );
        }

        $this->command->info('Lomba kategori data seeded successfully!');
    }
}
