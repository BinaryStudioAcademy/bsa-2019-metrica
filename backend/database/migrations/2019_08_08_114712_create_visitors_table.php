<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('visitor_type');
            $table->unsignedBigInteger('website_id');
            $table->timestamps();

            $table->foreign('website_id')
                ->references('id')
                ->on('websites');
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
