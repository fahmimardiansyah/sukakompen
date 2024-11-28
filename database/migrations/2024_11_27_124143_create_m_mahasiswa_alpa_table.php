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
        Schema::create('m_mahasiswa_alpa', function (Blueprint $table) {
            $table->id('alpa_id');
            $table->string('mahasiswa_alpa_nim')->unique();
            $table->string('mahasiswa_alpa_nama');
            $table->unsignedBigInteger('approval_id');
            $table->integer('jam_alpa');
            $table->timestamps();

            $table->foreign('approval_id')->references('approval_id')->on('t_approval_tugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_mahasiswa_alpa');
    }
};
