<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('errors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('message');
            $table->longText('stack_trace');
            $table->unsignedBigInteger('visitor_id')->nullable();
            $table->unsignedBigInteger('page_id');
            $table->timestamps();

            $table->foreign('visitor_id')
                ->references('id')
                ->on('visitors');

            $table->foreign('page_id')
                ->references('id')
                ->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('errors', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
            $table->dropForeign(['visitor_id']);
        });

        Schema::dropIfExists('errors');
    }
}
