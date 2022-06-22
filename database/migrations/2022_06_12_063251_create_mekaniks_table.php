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
        Schema::create('mekaniks', function (Blueprint $table) {
            $table->string('uid')->primary();
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->string('no_ktp')->unique();
            $table->date('tgl_lahir');
            $table->string('tempat_lahir');
            $table->string('no_telp');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('foto');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('desa');
            $table->float('rating')->default(0);
            $table->float('point')->default(0);
            $table->integer('hati')->default(3);
            $table->integer('job')->default(0);
            $table->string('jenis_kelamin');
            $table->string('kendaraan');
            $table->string('plat_nomor');
            $table->string('token_id')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('rekening_bank')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('jenis_pekerjaan');
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
        Schema::dropIfExists('mekaniks');
    }
};
