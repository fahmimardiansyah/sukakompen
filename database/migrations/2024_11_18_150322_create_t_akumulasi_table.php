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
        Schema::create('t_akumulasi', function (Blueprint $table) {
            $table->id('akumulasi_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->integer('semester');
            $table->integer('jumlah_alpa')->default(0);
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_akumulasi');
    }
};
