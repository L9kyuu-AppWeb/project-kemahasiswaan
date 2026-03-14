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
        Schema::table('rekognisi', function (Blueprint $table) {
            $table->foreignId('jenis_kegiatan_id')->nullable()->after('jenis_rekognisi_id')->constrained('jenis_kegiatan')->onDelete('set null');
            $table->foreignId('detail_kegiatan_id')->nullable()->after('jenis_kegiatan_id')->constrained('detail_kegiatan')->onDelete('set null');
            $table->foreignId('ruang_lingkup_id')->nullable()->after('detail_kegiatan_id')->constrained('ruang_lingkup')->onDelete('set null');
            $table->integer('nilai')->default(0)->after('ruang_lingkup_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekognisi', function (Blueprint $table) {
            $table->dropForeign(['jenis_kegiatan_id']);
            $table->dropForeign(['detail_kegiatan_id']);
            $table->dropForeign(['ruang_lingkup_id']);
            $table->dropColumn(['jenis_kegiatan_id', 'detail_kegiatan_id', 'ruang_lingkup_id', 'nilai']);
        });
    }
};
