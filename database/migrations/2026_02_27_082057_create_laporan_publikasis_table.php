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
        Schema::create('laporan_publikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_beasiswa_id')->constrained('laporan_beasiswas')->onDelete('cascade');
            $table->string('judul');
            $table->string('nama_tempat');
            $table->string('link_jurnal')->nullable();
            $table->string('kategori')->nullable(); // sinta 1-6, garuda, Q1-4
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_publikasis');
    }
};
