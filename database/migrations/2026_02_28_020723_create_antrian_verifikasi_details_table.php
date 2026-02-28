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
        Schema::create('antrian_verifikasi_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('antrian_verifikasi_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->date('tanggal_verifikasi');
            $table->time('jam_verifikasi')->nullable();
            $table->string('nomor_antrian');
            $table->enum('status', ['menunggu', 'terverifikasi', 'dibatalkan'])->default('menunggu');
            $table->boolean('hadir_verifikasi')->default(false);
            $table->text('keterangan')->nullable();
            $table->string('bukti_pdf_path')->nullable();
            $table->timestamps();

            $table->unique(['antrian_verifikasi_id', 'mahasiswa_id'], 'avd_av_id_mhs_id_unique');
            $table->index(['tanggal_verifikasi', 'status']);

            $table->foreign('antrian_verifikasi_id')->references('id')->on('antrian_verifikasis')->onDelete('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrian_verifikasi_details');
    }
};
