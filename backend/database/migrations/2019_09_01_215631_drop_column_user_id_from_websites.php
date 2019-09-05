<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Website;

class DropColumnUserIdFromWebsites extends Migration
{
    public function up()
    {
        Website::where('user_id', '>', 0)
        ->get(['id'])
        ->map(function($website){
            $website->users()
            ->attach($website->id, ['role' => 'owner']);
        });

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
