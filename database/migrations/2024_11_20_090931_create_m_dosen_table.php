<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_dosen', function (Blueprint $table) {
            $table->id('dosen_id');
            $table->string('dosen_nama');
            $table->string('nidn')->unique();
            $table->string('username')->unique();
            $table->string('no_telp');
            $table->unsignedBigInteger('tugas_id');
            $table->foreign('tugas_id')->references('tugas_id')->on('t_tugas'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_dosen');
    }
};
