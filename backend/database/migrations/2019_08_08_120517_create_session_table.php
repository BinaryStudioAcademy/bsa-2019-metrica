<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('start_session');
            $table->timestamp('end_session');
            $table->unsignedBigInteger('visitor_id');
            $table->unsignedBigInteger('entrance_page_id');
            $table->unsignedBigInteger('demographic_id');
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('system_id');
            $table->timestamps();

            $table->foreign('visitor_id')
                ->references('id')
                ->on('visitors');

            $table->foreign('entrance_page_id')
                ->references('id')
                ->on('pages');

            $table->foreign('demographic_id')
                ->references('id')
                ->on('demographic');

            $table->foreign('device_id')
                ->references('id')
                ->on('devices');

            $table->foreign('system_id')
                ->references('id')
                ->on('systems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session');
    }
}
