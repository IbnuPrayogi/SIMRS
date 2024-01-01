// Migration untuk tabel jadwals

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
            $table->unsignedBigInteger('shift_id');
            
            // Tambahkan kolom untuk setiap tanggal dalam bulan
            for ($day = 1; $day <= 31; $day++) {
                $table->unsignedBigInteger("tanggal_$day")->nullable();
            }
            $table->unsignedBigInteger('bulan');

            $table->timestamps();

      
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwals');
    }
};
