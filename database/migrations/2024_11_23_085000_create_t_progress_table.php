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
        Schema::create('t_progress', function (Blueprint $table) {
            $table->id('progress_id');
            $table->unsignedBigInteger('apply_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('tugas_id');
            $table->string('file_mahasiswa')->default(null)->nullable();
            $table->boolean('status')->default(null);
            $table->timestamps();

            $table->foreign('apply_id')->references('apply_id')->on('t_apply');
            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
            $table->foreign('tugas_id')->references('tugas_id')->on('t_tugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_progress');
    }
};
