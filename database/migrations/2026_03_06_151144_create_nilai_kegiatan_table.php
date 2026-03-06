<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_id')->constrained('jenis_kegiatan')->onDelete('cascade');
            $table->foreignId('detail_id')->constrained('detail_kegiatan')->onDelete('cascade');
            $table->foreignId('ruang_id')->constrained('ruang_lingkup')->onDelete('cascade');
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_kegiatan');
    }
};
