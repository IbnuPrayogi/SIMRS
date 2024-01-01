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
        Schema::create('tukar_jaga', function (Blueprint $table) {
            $table->bigIncrements('id'); // Kolom id Utama
            $table->string('nama_pengaju');
            $table->string('target_tukar_jaga');
            $table->string('file')->nullable(); // Kolom file dapat NULL
            $table->string('tanda_tangan')->nullable(); // Kolom tanda_tangan dapat NULL
            $table->string('keterangan');
            $table->date('jadwal_asli');
            $table->string('status');
            $table->date('jadwal_dirubah')->nullable(); // Kolom jadwal_dirubah dapat NULL
            $table->string('nama_surat')->nullable(); // Kolom nama_surat dapat NULL
            $table->string('kepala_bagian')->nullable();
            $table->string('nama_kepala_bagian')->nullable(); 
            $table->string('nama_kepala_ruangan')->nullable();// Kolom kepala_bagian dapat NULL
            $table->string('kepala_ruangan')->nullable(); // Kolom kepala_ruangan dapat NULL
            $table->string('termohon')->nullable(); // Kolom termohon dapat NULL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_tukar_jagas');
    }
};
