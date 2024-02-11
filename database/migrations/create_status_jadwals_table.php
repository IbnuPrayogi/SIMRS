<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('status_jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('bulan');
            $table->string('tahun');
            $table->string('status');
            $table->string('nama_bagian');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('status_jadwal');
    }
};
