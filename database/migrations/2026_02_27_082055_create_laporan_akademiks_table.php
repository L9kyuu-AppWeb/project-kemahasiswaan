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
        Schema::create('laporan_akademiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_beasiswa_id')->constrained('laporan_beasiswas')->onDelete('cascade');
            $table->integer('sks');
            $table->decimal('indeks_prestasi', 4, 2);
            $table->string('file_khs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_akademiks');
    }
};
