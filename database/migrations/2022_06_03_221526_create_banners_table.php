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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('deskripsi');
            $table->string('link');
            $table->string('foto');
            $table->char('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade')->onUpdate('cascade');
            $table->char('regencie_id')->nullable();
            $table->foreign('regencie_id')->references('id')->on('regencies')->onDelete('cascade')->onUpdate('cascade');
            $table->char('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('banners');
    }
};
