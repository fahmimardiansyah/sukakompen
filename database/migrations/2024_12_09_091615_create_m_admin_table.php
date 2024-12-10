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
        Schema::create('m_admin', function (Blueprint $table) {
            $table->id('admin_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nip')->unique();
            $table->string('admin_nama');
            $table->string('admin_no_telp');
            $table->string('admin_email');
            $table->timestamps();

            $table->foreign(columns: 'user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_admin', function (Blueprint $table) {
            Schema::dropIfExists('m_admin');
        });
    }
};
