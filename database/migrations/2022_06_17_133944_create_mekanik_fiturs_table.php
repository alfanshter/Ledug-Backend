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
        Schema::create('mekanik_fiturs', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_pekerjaan');
            $table->string('mekanik_uid');
            $table->foreign('mekanik_uid')->references('uid')->on('mekaniks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('fitur_id');
            $table->foreign('fitur_id')->references('id')->on('fiturs')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('mekanik_fiturs');
    }
};
