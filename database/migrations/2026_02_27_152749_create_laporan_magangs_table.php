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
        Schema::create('laporan_magangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_magang_id')->constrained('mahasiswa_magangs')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->string('judul_laporan');
            $table->text('deskripsi');
            $table->date('tanggal_kegiatan');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('lokasi_kegiatan');
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_magangs');
    }
};
