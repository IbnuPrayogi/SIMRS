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
        Schema::create('izin', function (Blueprint $table) {
            $table->bigIncrements('id'); // Kolom id Utama
            $table->string('nama_pengaju');
            $table->string('nama_surat')->nullable(); // Kolom nama_surat dapat NULL
            $table->date('tanggal_izin');
            $table->text('keterangan');
            $table->string('bukti');
            $table->string('status');
            $table->string('tanda_tangan')->nullable(); // Kolom tanda_tangan dapat NULL
            $table->string('file')->nullable(); // Kolom file dapat NULL
            $table->string('bagian');
            $table->string('manajer')->nullable();
            $table->string('nama_manajer')->nullable(); // Kolom manajer dapat NULL
            $table->timestamps(); // Tambahkan kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_surat_izin');
    }
};
