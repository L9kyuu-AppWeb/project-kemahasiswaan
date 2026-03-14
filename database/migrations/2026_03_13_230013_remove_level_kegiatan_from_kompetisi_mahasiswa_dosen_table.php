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
            $table->dropColumn('level_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kompetisi_mahasiswa_dosen', function (Blueprint $table) {
            $table->enum('level_kegiatan', ['Kabupaten/Kota', 'Provinsi/wilayah', 'Nasional', 'Internasional'])->after('id');
        });
    }
};
