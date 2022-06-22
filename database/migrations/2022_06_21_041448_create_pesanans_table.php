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
        //  is_status 
        //  0 = Sedang di proses mekanik
        //  1 = Perjalanan menuju lokasi anda
        //  2 = Mekanik sedang service
        //  3 = Selesai
        //  4 = batal

        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan');
            $table->string('mekanik_uid');
            $table->foreign('mekanik_uid')->references('uid')->on('mekaniks')->onDelete('cascade')->onUpdate('cascade');
            $table->string('user_uid');
            $table->foreign('user_uid')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('fitur_id');
            $table->foreign('fitur_id')->references('id')->on('fiturs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('latitude_user');
            $table->string('longitude_user');
            $table->string('latitude_mekanik');
            $table->string('longitude_mekanik');
            $table->integer('harga');
            $table->integer('ongkir');
            $table->integer('harga_total');
            $table->integer('pendapatan_mekanik');
            $table->integer('pendapatan_aplikasi');
            $table->string('jarak');
            $table->integer('is_status');
            $table->text('alamat_mekanik');
            $table->text('alamat_user');
            $table->string('alasan')->nullable();
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
        Schema::dropIfExists('pesanans');
    }
};
