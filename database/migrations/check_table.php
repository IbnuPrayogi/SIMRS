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
        Schema::create('check_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userid');
            $table->string('nama_karyawan');
            $table->timestamp('waktu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('check_times');
    }
};
