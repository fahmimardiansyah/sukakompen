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
        Schema::table('t_progress', function (Blueprint $table) {
            $table->boolean('status')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('t_progress', function (Blueprint $table) {
            $table->boolean('status')->nullable(false)->default(false)->change();
        });
    }
};
