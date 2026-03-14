<?php

use App\Models\Mahasiswa;
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
        Schema::table('kompetisi_mahasiswa_dosen', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->nullable()->after('nim')->constrained('mahasiswas')->onDelete('cascade');
        });

        // Populate mahasiswa_id based on existing nim
        DB::statement('
            UPDATE kompetisi_mahasiswa_dosen 
            INNER JOIN mahasiswas ON kompetisi_mahasiswa_dosen.nim = mahasiswas.nim 
            SET kompetisi_mahasiswa_dosen.mahasiswa_id = mahasiswas.id
        ');

        // Drop old columns
        Schema::table('kompetisi_mahasiswa_dosen', function (Blueprint $table) {
            $table->dropColumn(['nim', 'nama_mahasiswa']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kompetisi_mahasiswa_dosen', function (Blueprint $table) {
            $table->string('nim', 20)->nullable();
            $table->string('nama_mahasiswa', 150)->nullable();
        });

        // Populate nim and nama_mahasiswa from mahasiswa_id
        DB::statement('
            UPDATE kompetisi_mahasiswa_dosen 
            INNER JOIN mahasiswas ON kompetisi_mahasiswa_dosen.mahasiswa_id = mahasiswas.id 
            SET kompetisi_mahasiswa_dosen.nim = mahasiswas.nim, 
                kompetisi_mahasiswa_dosen.nama_mahasiswa = mahasiswas.nama
        ');

        Schema::table('kompetisi_mahasiswa_dosen', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropColumn('mahasiswa_id');
        });
    }
};
