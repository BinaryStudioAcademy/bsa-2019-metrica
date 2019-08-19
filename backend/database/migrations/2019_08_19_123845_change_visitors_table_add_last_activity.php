<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVisitorsTableAddLastActivity extends Migration
{

    public function up()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->timestamp('last_activity')->nullable();
        });
    }

    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropColumn('last_activity');
        });
    }
}
