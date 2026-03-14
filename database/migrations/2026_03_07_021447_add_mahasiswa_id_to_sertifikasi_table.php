<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sertifikasi', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->nullable()->after('nim')->constrained('mahasiswas')->onDelete('cascade');
        });

        // Populate mahasiswa_id based on existing nim
        DB::statement('
            UPDATE sertifikasi 
            INNER JOIN mahasiswas ON sertifikasi.nim = mahasiswas.nim 
            SET sertifikasi.mahasiswa_id = mahasiswas.id
        ');

        // Drop old columns
        Schema::table('sertifikasi', function (Blueprint $table) {
            $table->dropColumn(['nim', 'nama_mahasiswa']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sertifikasi', function (Blueprint $table) {
            $table->string('nim', 20)->nullable();
            $table->string('nama_mahasiswa', 150)->nullable();
        });

        // Populate nim and nama_mahasiswa from mahasiswa_id
        DB::statement('
            UPDATE sertifikasi 
            INNER JOIN mahasiswas ON sertifikasi.mahasiswa_id = mahasiswas.id 
            SET sertifikasi.nim = mahasiswas.nim, 
                sertifikasi.nama_mahasiswa = mahasiswas.nama
        ');

        Schema::table('sertifikasi', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropColumn('mahasiswa_id');
        });
    }
};
