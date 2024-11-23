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
        Schema::create('t_approval_tugas', function (Blueprint $table) {
            $table->id('approval_id');
            $table->unsignedBigInteger('progress_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('tugas_id');
            $table->boolean('status')->default(null);
            $table->timestamps();

            $table->foreign('progress_id')->references('progress_id')->on('t_progress');
            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
            $table->foreign('tugas_id')->references('tugas_id')->on('t_tugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_approval_tugas');
    }
};
