<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimingFieldsToVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->integer('page_load_time')->nullable()->default(450);
            $table->integer('domain_lookup_time')->nullable()->default(150);
            $table->integer('server_response_time')->nullable()->default(300);
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
            $table->dropColumn('page_load_time');
            $table->dropColumn('domain_lookup_time');
            $table->dropColumn('server_response_time');
        });
    }
}
