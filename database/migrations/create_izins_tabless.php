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
        Schema::create('potonganizin', function (Blueprint $table) {
            $table->id();
            $table->string('nama_karyawan');
            $table->unsignedBigInteger('shift_id');
            $table->date('tanggal');
            $table->integer('waktu_izin');
            $table->timestamps();

            // Definisi foreign key ke tabel user
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potonganizin');
    }
};
