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
        Schema::table('laporan_magangs', function (Blueprint $table) {
            $table->foreignId('tahun_ajar_id')->after('mahasiswa_id')->nullable()->constrained('tahun_ajars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_magangs', function (Blueprint $table) {
            $table->dropForeign(['tahun_ajar_id']);
            $table->dropColumn('tahun_ajar_id');
        });
    }
};
