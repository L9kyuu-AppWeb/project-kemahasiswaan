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
        Schema::table('kompetisi_mahasiswa_dosen', function (Blueprint $table) {
            $table->foreignId('dosen_id')->nullable()->after('nama_dosen')->constrained('dosens')->onDelete('cascade');
            $table->dropColumn(['nidn_nuptk', 'nama_dosen']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kompetisi_mahasiswa_dosen', function (Blueprint $table) {
            $table->dropForeign(['dosen_id']);
            $table->dropColumn('dosen_id');
            $table->string('nidn_nuptk', 30)->nullable();
            $table->string('nama_dosen', 150)->nullable();
        });
    }
};
