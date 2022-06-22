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
        // is_aktif 
        // 0 = tidak aktif 
        // 1 = aktif
        // 2 = sedang bekerja

        //is_fitur = motor,mobil

        Schema::create('job_mekaniks', function (Blueprint $table) {
            $table->id();
            $table->string('mekanik_uid');
            $table->foreign('mekanik_uid')->references('uid')->on('mekaniks')->onDelete('cascade')->onUpdate('cascade');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->float('bearing')->nullable();
            $table->string('is_aktif')->default(1);
            $table->string('is_fitur')->nullable();
            $table->string('kode_pesanan')->nullable();
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
        Schema::dropIfExists('job_mekaniks');
    }
};
