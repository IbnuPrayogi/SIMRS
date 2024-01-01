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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->bigIncrements('id'); // Kolom id Utama
            $table->string('nama_surat');
            $table->string('kategori');
            $table->string('perihal');
            $table->date('tanggal_dibuat');
            $table->string('asal_surat');
            $table->string('status')->nullable(); // Kolom status dapat NULL
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
