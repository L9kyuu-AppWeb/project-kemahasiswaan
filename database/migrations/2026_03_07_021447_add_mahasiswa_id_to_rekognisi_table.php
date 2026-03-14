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
        Schema::table('rekognisi', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->nullable()->after('nim')->constrained('mahasiswas')->onDelete('cascade');
        });

        // Populate mahasiswa_id based on existing nim
        DB::statement('
            UPDATE rekognisi 
            INNER JOIN mahasiswas ON rekognisi.nim = mahasiswas.nim 
            SET rekognisi.mahasiswa_id = mahasiswas.id
        ');

        // Drop old columns
        Schema::table('rekognisi', function (Blueprint $table) {
            $table->dropColumn(['nim', 'nama_mahasiswa']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekognisi', function (Blueprint $table) {
            $table->string('nim', 20)->nullable();
            $table->string('nama_mahasiswa', 150)->nullable();
        });

        // Populate nim and nama_mahasiswa from mahasiswa_id
        DB::statement('
            UPDATE rekognisi 
            INNER JOIN mahasiswas ON rekognisi.mahasiswa_id = mahasiswas.id 
            SET rekognisi.nim = mahasiswas.nim, 
                rekognisi.nama_mahasiswa = mahasiswas.nama
        ');

        Schema::table('rekognisi', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropColumn('mahasiswa_id');
        });
    }
};
