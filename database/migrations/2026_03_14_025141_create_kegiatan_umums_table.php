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
        Schema::create('kegiatan_umums', function (Blueprint $table) {
            $table->id();
            $table->string('kategori', 100);
            $table->foreignId('jenis_kegiatan_id')->nullable()->constrained('jenis_kegiatan')->onDelete('set null');
            $table->foreignId('detail_kegiatan_id')->nullable()->constrained('detail_kegiatan')->onDelete('set null');
            $table->foreignId('ruang_lingkup_id')->nullable()->constrained('ruang_lingkup')->onDelete('set null');
            $table->integer('nilai')->default(0);
            $table->string('nama_kompetisi', 255);
            $table->string('penyelenggara', 255);
            $table->text('url_kegiatan')->nullable();
            $table->text('dokumen_sertifikat')->nullable();
            $table->date('tanggal_sertifikat')->nullable();
            $table->foreignId('mahasiswa_id')->nullable()->constrained('mahasiswas')->onDelete('set null');
            $table->foreignId('dosen_id')->nullable()->constrained('dosens')->onDelete('set null');
            $table->string('url_surat_tugas', 255)->nullable();
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
        Schema::dropIfExists('kegiatan_umums');
    }
};
