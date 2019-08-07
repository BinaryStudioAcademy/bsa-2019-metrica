<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrackingInfoTable extends Migration
{
    public function up()
    {
        Schema::create('tracking_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tracking_id')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracking_info');
    }
}
