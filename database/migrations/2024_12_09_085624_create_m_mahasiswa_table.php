<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_mahasiswa', function (Blueprint $table) {
            $table->id('mahasiswa_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nim')->unique();
            $table->string('mahasiswa_nama');
            $table->integer('jumlah_alpa');
            $table->unsignedBigInteger('prodi_id');
            $table->integer('semester');
            $table->timestamps();

            $table->foreign('prodi_id')->references('prodi_id')->on('m_prodi');
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_mahasiswa', function (Blueprint $table) {
            Schema::dropIfExists('m_mahasiswa');
        });
    }
};
