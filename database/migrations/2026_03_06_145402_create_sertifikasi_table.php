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
        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->id();
            $table->enum('level', ['Provinsi', 'Nasional', 'Internasional']);
            $table->string('nama_sertifikasi', 255);
            $table->string('nama_penyelenggara', 255);
            $table->string('url_sertifikasi', 255)->nullable();
            $table->string('dokumen_sertifikat')->nullable();
            $table->string('foto_kegiatan')->nullable();
            $table->string('dokumen_bukti')->nullable();
            $table->date('tanggal_sertifikat')->nullable();
            $table->string('nim', 20);
            $table->string('nama_mahasiswa', 150);
            $table->string('nidn_nuptk', 30)->nullable();
            $table->string('nama_dosen', 150)->nullable();
            $table->string('url_surat_tugas')->nullable();
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
        Schema::dropIfExists('sertifikasi');
    }
};
