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
        Schema::create('laporan_referals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_beasiswa_id')->constrained('laporan_beasiswas')->onDelete('cascade');
            $table->string('nama');
            $table->string('no_telp');
            $table->string('program_studi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_referals');
    }
};
