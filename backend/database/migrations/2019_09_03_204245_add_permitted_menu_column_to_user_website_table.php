<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class AddPermittedMenuColumnToUserWebsiteTable extends Migration
{
    public function up()
    {
        Schema::table('user_website', function (Blueprint $table) {
            $table->string('permitted_menu')->default(
                config('sidebar.partial_access_menu_items')
            );
        });
    }

    public function down()
    {
        Schema::table('user_website', function (Blueprint $table) {
            $table->dropColumn('permitted_menu');
        });
    }
}
