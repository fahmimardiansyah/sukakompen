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
        Schema::create('t_tugas', function (Blueprint $table) {
            $table->id('tugas_id');
            $table->unsignedBigInteger('user_id');
            $table->uuid('tugas_No', )->unique();
            $table->string('tugas_nama');
            $table->unsignedBigInteger('jenis_id');
            $table->enum('tugas_tipe', ['online', 'offline']);
            $table->string('tugas_deskripsi');
            $table->integer('tugas_kuota');
            $table->integer('tugas_jam_kompen');
            $table->dateTime('tugas_tenggat');
            $table->unsignedBigInteger('kompetensi_id');
            $table->timestamps();

            $table->foreign('jenis_id')->references('jenis_id')->on('m_jenis');
            $table->foreign('kompetensi_id')->references('kompetensi_id')->on('t_kompetensi');
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_tugas');
    }
};