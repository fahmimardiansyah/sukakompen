<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplyStatusNullableInTApplyTable extends Migration
{
    public function up()
    {
        Schema::table('t_apply', function (Blueprint $table) {
            $table->boolean('apply_status')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('t_apply', function (Blueprint $table) {
            $table->boolean('apply_status')->nullable(false)->default(false)->change();
        });
    }
}

