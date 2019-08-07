<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsitesTable extends Migration
{
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('domain')->unique();
            $table->boolean('single_page');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tracking_info_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('tracking_info_id')
                ->references('id')
                ->on('tracking_info');
        });
    }

    public function down()
    {
        Schema::dropIfExists('websites');
    }
}
