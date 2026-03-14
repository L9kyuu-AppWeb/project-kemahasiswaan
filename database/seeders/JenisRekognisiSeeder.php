<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisRekognisi;

class JenisRekognisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisRekognisiData = [
            ['id' => 1, 'nama' => 'Keynote speaker conference nasional/internasional'],
            ['id' => 2, 'nama' => 'Keynote speaker workshop/pelatihan/bimbingan teknis nasional/internasional'],
            ['id' => 3, 'nama' => 'Peserta pameran karya seni'],
            ['id' => 4, 'nama' => 'Karya cipta lagu dan/atau seni tari'],
            ['id' => 5, 'nama' => 'Penulis buku'],
            ['id' => 6, 'nama' => 'Paten/Paten Sederhana'],
            ['id' => 7, 'nama' => 'Publikasi artikel ilmiah'],
            ['id' => 8, 'nama' => 'Duta (Brand Ambassador)'],
        ];

        foreach ($jenisRekognisiData as $data) {
            JenisRekognisi::create($data);
        }

        $this->command->info('Jenis rekognisi data seeded successfully!');
    }
}
