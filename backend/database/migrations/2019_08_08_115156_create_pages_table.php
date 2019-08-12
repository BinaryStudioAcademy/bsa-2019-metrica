<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('url');
            $table->unsignedInteger('previews');
            $table->unsignedBigInteger('website_id');
            $table->timestamps();

            $table->foreign('website_id')
                ->references('id')
                ->on('websites');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
