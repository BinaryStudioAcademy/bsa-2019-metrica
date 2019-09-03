<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnUserIdFromWebsites extends Migration
{
    public function up()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }

    public function down()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
        });
    }
}
