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
        Schema::table('mahasiswa_magangs', function (Blueprint $table) {
            $table->string('dosen_pembimbing_nama')->nullable()->after('no_telp_pembimbing');
            $table->string('dosen_pembimbing_nik')->nullable()->after('dosen_pembimbing_nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa_magangs', function (Blueprint $table) {
            $table->dropColumn(['dosen_pembimbing_nama', 'dosen_pembimbing_nik']);
        });
    }
};
