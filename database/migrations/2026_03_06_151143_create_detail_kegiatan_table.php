<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_id')->constrained('jenis_kegiatan')->onDelete('cascade');
            $table->string('nama', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_kegiatan');
    }
};
