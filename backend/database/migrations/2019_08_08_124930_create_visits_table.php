<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('visit_time');
            $table->string('ip_address');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('visitor_id');
            $table->unsignedBigInteger('device_id');
            $table->timestamps();

            $table->foreign('session_id')
                ->references('id')
                ->on('session');

            $table->foreign('page_id')
                ->references('id')
                ->on('pages');

            $table->foreign('visitor_id')
                ->references('id')
                ->on('visitors');

            $table->foreign('device_id')
                ->references('id')
                ->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
