<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Kolom id Utama
            $table->string('role', 11);
            $table->string('nama_karyawan');
            $table->string('email')->index();
            $table->string('jabatan');
            $table->string('nik')->index();
            $table->string('password');
            $table->string('foto')->nullable(); // Kolom foto dapat NULL
            $table->string('alamat');
            $table->string('nomor_hp');
            $table->string('tanda_tangan');
            $table->string('nama_bagian');
            $table->integer('jumlah_izin')->nullable(); // Kolom jumlah_izin dapat NULL
            $table->integer('jumlah_cuti')->nullable(); // Kolom jumlah_cuti dapat NULL
            $table->integer('jumlah_tukar_jaga')->nullable(); // Kolom jumlah_tukar_jaga dapat NULL
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
