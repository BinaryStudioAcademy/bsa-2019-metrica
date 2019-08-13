<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameDemographicGeoPositionsIdForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demographics', function (Blueprint $table) {
            $table->dropForeign('demographic_geo_positions_id_foreign');

            $table->renameColumn('geo_positions_id', 'geo_position_id');

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
        Schema::table('demographics', function (Blueprint $table) {
            $table->dropForeign(['geo_position_id']);

            $table->renameColumn('geo_position_id', 'geo_positions_id');

            $table->foreign('geo_positions_id')
                ->references('id')
                ->on('geo_positions');
        });
    }
}
