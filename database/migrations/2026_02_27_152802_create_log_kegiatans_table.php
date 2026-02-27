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
        Schema::create('log_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_magang_id')->constrained('laporan_magangs')->onDelete('cascade');
            $table->date('tanggal');
            $table->text('uraian_kegiatan');
            $table->text('hasil_kegiatan')->nullable();
            $table->text('kendala')->nullable();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_kegiatans');
    }
};
