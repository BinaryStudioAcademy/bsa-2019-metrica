<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWebsiteTable extends Migration
{
    public function up()
    {
        Schema::create('user_website', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('website_id');
            $table->enum('role', ['owner', 'member']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('website_id')
                ->references('id')
                ->on('websites')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_website');
    }
}
