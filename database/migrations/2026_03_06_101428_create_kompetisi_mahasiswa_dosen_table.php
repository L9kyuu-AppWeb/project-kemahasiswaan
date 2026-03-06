<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kompetisi_mahasiswa_dosen', function (Blueprint $table) {
            $table->id();
            $table->enum('level_kegiatan', ['Kabupaten/Kota', 'Provinsi/wilayah', 'Nasional', 'Internasional']);
            $table->string('kategori', 100);
            $table->string('nama_kompetisi', 255);
            $table->string('nama_cabang', 255)->nullable();
            $table->enum('peringkat', ['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Harapan 3', 'Apresiasi Kejuaraan', 'Penghargaan Tambahan', 'Juara Umum', 'Peserta']);
            $table->string('penyelenggara', 255);
            $table->string('jumlah_pt_negara_peserta', 100)->nullable();
            $table->enum('kepesertaan', ['Individu', 'Kelompok']);
            $table->enum('bentuk', ['Luring/Hibrida', 'Daring']);
            $table->text('url_kompetisi')->nullable();
            $table->text('dokumen_sertifikat')->nullable();
            $table->date('tanggal_sertifikat')->nullable();
            $table->text('foto_upp')->nullable();
            $table->text('dokumen_undangan')->nullable();
            $table->string('nim', 20);
            $table->string('nama_mahasiswa', 150);
            $table->string('nidn_nuptk', 30)->nullable();
            $table->string('nama_dosen', 150)->nullable();
            $table->text('url_surat_tugas')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('keterangan_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kompetisi_mahasiswa_dosen');
    }
};
