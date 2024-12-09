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
        Schema::create('m_dosen', function (Blueprint $table) {
            $table->id('dosen_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nidn')->unique();
            $table->string('dosen_nama');
            $table->string('dosen_no_telp');
            $table->string('dosen_email');
            $table->timestamps();

            $table->foreign(columns: 'user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_dosen', function (Blueprint $table) {
            Schema::dropIfExists('m_dosen');
        });
    }
};
