<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inoutdata', function (Blueprint $table) {
            $table->id();
            $table->string('badgenumber');
            $table->string('username');
            $table->string('deptname');
            $table->date('sDate');
            $table->string('stime'); // Jika data ini menunjukkan waktu yang berbeda, pertimbangkan membuat kolom terpisah untuk waktu masuk dan waktu keluar.
            $table->date('eDate');
            // Tambahkan kolom lain sesuai kebutuhan, seperti waktu keluar, dsb.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presensi');
    }
};
