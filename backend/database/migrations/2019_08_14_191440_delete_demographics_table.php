<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteDemographicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demographics', function (Blueprint $table) {
            $table->dropForeign(['geo_position_id']);
        });

        Schema::dropIfExists('demographics');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('demographics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('language');
            $table->unsignedBigInteger('geo_position_id');
            $table->timestamps();

            $table->foreign('geo_position_id')
                ->references('id')
                ->on('geo_positions');
        });
    }
}
