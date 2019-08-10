<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemographicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demographic', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('language');
            $table->unsignedBigInteger('geo_positions_id');
            $table->timestamps();

            $table->foreign('geo_positions_id')
                ->references('id')
                ->on('geo_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demographic');
    }
}
