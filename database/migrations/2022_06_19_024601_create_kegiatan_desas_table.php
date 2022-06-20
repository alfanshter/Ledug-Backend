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
        Schema::create('kegiatan_desas', function (Blueprint $table) {
            $table->id();
            $table->string('kegiatan_desa');
            $table->string('nama_kegiatan');
            $table->date('tanggal');
            $table->time('jam');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->char('village_id')->nullable();
            $table->foreign('village_id')->references('id')->on('villages')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('kegiatan_desas');
    }
};
