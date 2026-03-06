<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RuangLingkup;
use App\Models\JenisKegiatan;
use App\Models\DetailKegiatan;
use App\Models\NilaiKegiatan;

class MasterKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Ruang Lingkup
        $ruangLingkupData = [
            ['id' => 1, 'nama' => 'Lokal'],
            ['id' => 2, 'nama' => 'Kota'],
            ['id' => 3, 'nama' => 'Provinsi'],
            ['id' => 4, 'nama' => 'Wilayah'],
            ['id' => 5, 'nama' => 'Nasional'],
            ['id' => 6, 'nama' => 'Internasional'],
        ];

        foreach ($ruangLingkupData as $data) {
            RuangLingkup::create($data);
        }

        // Seed Jenis Kegiatan
        $jenisKegiatanData = [
            ['id' => 7, 'nama' => 'Orientasi Mahasiswa Baru'],
            ['id' => 8, 'nama' => 'Kompetensi sesuai dengan bidang keilmuan'],
            ['id' => 9, 'nama' => 'Penelitian'],
            ['id' => 10, 'nama' => 'Program Kreativitas Mahasiswa (PKM)'],
            ['id' => 12, 'nama' => 'Kompetisi Kemristekdikti'],
            ['id' => 40, 'nama' => 'Kegiatan Ilmiah (Seminar, Workshop, Konferensi, Lokakarya, Diskusi)'],
            ['id' => 41, 'nama' => 'Tulisan di koran, majalah, dll'],
            ['id' => 42, 'nama' => 'Peserta pertukaran mahasiswa bidang akademik'],
            ['id' => 43, 'nama' => 'Pengabdian Masyarakat sesuai dengan bidang keilmuan'],
            ['id' => 44, 'nama' => 'Pertunjukkan/Pameran/Konser sesuai bidang keilmuan'],
            ['id' => 45, 'nama' => 'Struktur Kelas:'],
            ['id' => 46, 'nama' => 'Penanggungjawab Mata Kuliah (PJMK)'],
            ['id' => 47, 'nama' => 'Kerohanian'],
            ['id' => 48, 'nama' => 'Kepemimpinan'],
            ['id' => 49, 'nama' => 'a. Lembaga Kemahasiswaan ORMAWA'],
            ['id' => 50, 'nama' => 'b. Kelompok Minat Bakat (UKM)'],
            ['id' => 51, 'nama' => 'Kepanitiaan'],
            ['id' => 52, 'nama' => 'Kompetisi'],
            ['id' => 53, 'nama' => 'Konser/Pameran/Pementasan'],
            ['id' => 54, 'nama' => 'Pengabdian Masyarakat di luar bidang keilmuan'],
            ['id' => 55, 'nama' => 'Peserta pertukaran mahasiswa bidang non-akademik'],
            ['id' => 56, 'nama' => 'Membantu pembuatan/ pembaharuan web atau system database suatu kegiatan/lembaga'],
            ['id' => 57, 'nama' => 'Kegiatan di luar bidang kompetensi professional dan kompetensi kepribadian dan sosial'],
        ];

        foreach ($jenisKegiatanData as $data) {
            JenisKegiatan::create($data);
        }

        // Seed Detail Kegiatan (sample data - key entries)
        $detailKegiatanData = [
            ['id' => 12, 'jenis_id' => 7, 'nama' => 'Orientasi Mahasiswa Baru'],
            ['id' => 13, 'jenis_id' => 8, 'nama' => 'Peserta'],
            ['id' => 15, 'jenis_id' => 8, 'nama' => 'Finalis'],
            ['id' => 16, 'jenis_id' => 8, 'nama' => 'Juara III'],
            ['id' => 17, 'jenis_id' => 8, 'nama' => 'Juara II'],
            ['id' => 19, 'jenis_id' => 8, 'nama' => 'Juara I'],
            ['id' => 20, 'jenis_id' => 9, 'nama' => 'Terlibat Penelitian Dosen'],
            ['id' => 22, 'jenis_id' => 10, 'nama' => 'Proposal'],
            ['id' => 23, 'jenis_id' => 10, 'nama' => 'Proposal di unggah'],
            ['id' => 24, 'jenis_id' => 10, 'nama' => 'Laporan kemajuan'],
            ['id' => 25, 'jenis_id' => 10, 'nama' => 'Pelaksanaan dan laporan akhir'],
            ['id' => 26, 'jenis_id' => 10, 'nama' => 'Lolos dan Pendanaan PIMNAS'],
            ['id' => 29, 'jenis_id' => 12, 'nama' => 'Peserta'],
            ['id' => 30, 'jenis_id' => 12, 'nama' => 'Delegasi'],
            ['id' => 31, 'jenis_id' => 12, 'nama' => 'Juara III'],
            ['id' => 32, 'jenis_id' => 12, 'nama' => 'Juara II'],
            ['id' => 33, 'jenis_id' => 12, 'nama' => 'Juara I'],
            ['id' => 171, 'jenis_id' => 40, 'nama' => 'Peserta'],
            ['id' => 172, 'jenis_id' => 40, 'nama' => 'Moderator'],
            ['id' => 173, 'jenis_id' => 40, 'nama' => 'Penyaji Poster'],
            ['id' => 174, 'jenis_id' => 40, 'nama' => 'Narasumber'],
            ['id' => 190, 'jenis_id' => 45, 'nama' => 'Ketua Kelas'],
            ['id' => 191, 'jenis_id' => 45, 'nama' => 'Wakil Ketua Kelas'],
            ['id' => 192, 'jenis_id' => 45, 'nama' => 'Sekretaris'],
            ['id' => 193, 'jenis_id' => 45, 'nama' => 'Bendahara'],
            ['id' => 194, 'jenis_id' => 46, 'nama' => 'Penanggungjawab Mata Kuliah (PJMK)'],
            ['id' => 249, 'jenis_id' => 52, 'nama' => 'Peserta'],
            ['id' => 250, 'jenis_id' => 52, 'nama' => 'Finalis'],
            ['id' => 265, 'jenis_id' => 52, 'nama' => 'Juara I (P)'],
            ['id' => 266, 'jenis_id' => 52, 'nama' => 'Juara I (F)'],
            ['id' => 267, 'jenis_id' => 52, 'nama' => 'Juara I (U)'],
        ];

        foreach ($detailKegiatanData as $data) {
            DetailKegiatan::create($data);
        }

        // Seed Nilai Kegiatan (sample data - key entries)
        $nilaiKegiatanData = [
            ['jenis_id' => 7, 'detail_id' => 12, 'ruang_id' => 1, 'nilai' => 15],
            ['jenis_id' => 8, 'detail_id' => 13, 'ruang_id' => 1, 'nilai' => 3],
            ['jenis_id' => 8, 'detail_id' => 13, 'ruang_id' => 5, 'nilai' => 15],
            ['jenis_id' => 8, 'detail_id' => 13, 'ruang_id' => 6, 'nilai' => 25],
            ['jenis_id' => 8, 'detail_id' => 19, 'ruang_id' => 5, 'nilai' => 55],
            ['jenis_id' => 8, 'detail_id' => 19, 'ruang_id' => 6, 'nilai' => 65],
            ['jenis_id' => 10, 'detail_id' => 26, 'ruang_id' => 5, 'nilai' => 50],
            ['jenis_id' => 12, 'detail_id' => 33, 'ruang_id' => 5, 'nilai' => 55],
            ['jenis_id' => 12, 'detail_id' => 33, 'ruang_id' => 6, 'nilai' => 65],
            ['jenis_id' => 45, 'detail_id' => 190, 'ruang_id' => 1, 'nilai' => 25],
            ['jenis_id' => 46, 'detail_id' => 194, 'ruang_id' => 1, 'nilai' => 25],
            ['jenis_id' => 52, 'detail_id' => 249, 'ruang_id' => 5, 'nilai' => 10],
            ['jenis_id' => 52, 'detail_id' => 249, 'ruang_id' => 6, 'nilai' => 20],
            ['jenis_id' => 52, 'detail_id' => 267, 'ruang_id' => 5, 'nilai' => 90],
            ['jenis_id' => 52, 'detail_id' => 267, 'ruang_id' => 6, 'nilai' => 100],
        ];

        foreach ($nilaiKegiatanData as $data) {
            NilaiKegiatan::create($data);
        }

        $this->command->info('Master kegiatan data seeded successfully!');
    }
}
