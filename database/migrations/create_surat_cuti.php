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
        Schema::create('cuti', function (Blueprint $table) {
            $table->bigIncrements('id'); // Kolom id Utama
            $table->string('nama_pengaju');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('bagian');
            $table->string('alamat');
            $table->string('jabatan');
            $table->text('keterangan');
            $table->string('status');
            $table->string('file')->nullable(); // Kolom file dapat NULL
            $table->string('nama_surat')->nullable(); // Kolom nama_surat dapat NULL
            $table->string('kepala_bagian')->nullable();
            $table->string('nama_kepala_bagian')->nullable(); // Kolom kepala_bagian dapat NULL
            $table->string('tanda_tangan')->nullable(); // Kolom tanda_tangan dapat NULL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_cutis');
    }
};
