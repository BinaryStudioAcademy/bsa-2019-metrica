<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVisitsTableAddGeoLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->unsignedBigInteger('geo_position_id')->nullable();

            $table->foreign('geo_position_id')
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
        Schema::table('visits', function (Blueprint $table) {
            $table->dropForeign(['geo_position_id']);
            $table->dropColumn('geo_position_id');
        });
    }
}
