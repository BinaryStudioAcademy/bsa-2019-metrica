<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferentialActionToSessionsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropForeign('session_demographic_id_foreign');

            $table->foreign('demographic_id')
                ->references('id')
                ->on('demographic')
                ->onDelete('cascade');

            $table->dropForeign('session_system_id_foreign');

            $table->foreign('system_id')
                ->references('id')
                ->on('systems')
                ->onDelete('cascade');

            $table->dropForeign('session_device_id_foreign');

            $table->foreign('device_id')
                ->references('id')
                ->on('devices')
                ->onDelete('cascade');

            $table->dropForeign('session_entrance_page_id_foreign');

            $table->foreign('entrance_page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');

            $table->dropForeign('session_visitor_id_foreign');

            $table->foreign('visitor_id')
                ->references('id')
                ->on('visitors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropForeign(['demographic_id']);

            $table->foreign('demographic_id')
                    ->references('id')
                    ->on('demographic');

            $table->dropForeign(['system_id']);

            $table->foreign('system_id')
                ->references('id')
                ->on('systems');

            $table->dropForeign(['device_id']);

            $table->foreign('device_id')
                ->references('id')
                ->on('devices');

            $table->dropForeign(['entrance_page_id']);

            $table->foreign('entrance_page_id')
                ->references('id')
                ->on('pages');


            $table->dropForeign(['visitor_id']);

            $table->foreign('visitor_id')
                ->references('id')
                ->on('visitors');
        });
    }
}
