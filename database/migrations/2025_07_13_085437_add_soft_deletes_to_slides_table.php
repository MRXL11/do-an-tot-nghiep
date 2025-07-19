<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToSlidesTable extends Migration
{
    public function up()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}