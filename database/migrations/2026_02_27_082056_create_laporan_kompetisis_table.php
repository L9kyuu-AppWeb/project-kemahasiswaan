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
        Schema::create('laporan_kompetisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_beasiswa_id')->constrained('laporan_beasiswas')->onDelete('cascade');
            $table->string('nama_kompetisi');
            $table->string('judul');
            $table->string('juara')->nullable(); // Juara 1, 2, 3, terbaik, atau null
            $table->enum('posisi', ['ketua', 'anggota'])->default('anggota');
            $table->string('file_bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kompetisis');
    }
};
