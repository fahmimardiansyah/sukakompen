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
        Schema::table('m_user', function (Blueprint $table) {
            $table->blob('foto')->nullable(); // Tambahkan kolom foto yang bisa null
        });
    }

    public function down()
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
