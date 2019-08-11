<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('screen_resolution');
            $table->unsignedBigInteger('browser_id');
            $table->unsignedBigInteger('os_id');
            $table->timestamps();

            $table->foreign('browser_id')
                ->references('id')
                ->on('browsers');

            $table->foreign('os_id')
                ->references('id')
                ->on('os');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('systems');
    }
}
