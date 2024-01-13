<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_shift');
            $table->string('kode_shift');
            $table->string('bagian');
            $table->time('cin1');
            $table->time('cout1');
            $table->time('cin2')->nullable();
            $table->time('cout2')->nullable();
            $table->time('lama_waktu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shifts');
    }
};