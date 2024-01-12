<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            // Add columns for each day of the month (tanggal_1, tanggal_2, ..., tanggal_31)
            for ($day = 1; $day <= 31; $day++) {
                $table->unsignedBigInteger("tanggal_$day")->nullable();
            }
            $table->time('jumlah_jam_kerja');

            $table->string('bulan'); // Assuming 'bulan' is a string, adjust if it's supposed to be an integer
            $table->timestamps();


            // You might need to adjust other constraints or indexes based on your requirements
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwals');
    }
};
