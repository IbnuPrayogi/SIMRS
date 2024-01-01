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
        Schema::create('template_SK', function (Blueprint $table) {
            $table->bigIncrements('id'); // Kolom id Utama
            $table->integer('id_surat');
            $table->string('perihal');
            $table->string('hari_tanggal');
            $table->string('waktu');
            $table->string('tempat');
            $table->string('tanggal_surat');
            $table->string('pembuat_surat');
            $table->string('tanda_tangan')->nullable(); // Kolom tanda_tangan dapat NULL
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_s_k_s');
    }
};
