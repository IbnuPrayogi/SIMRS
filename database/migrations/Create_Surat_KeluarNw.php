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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id(); // Kolom id Utama
            $table->string('nama_surat');
            $table->string('kategori_surat');
            $table->string('kode_surat');
            $table->date('tanggal_dibuat');
            $table->string('jenis_surat');
            $table->string('pembuat_surat');
            $table->string('tujuan_surat');
            $table->string('file');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
