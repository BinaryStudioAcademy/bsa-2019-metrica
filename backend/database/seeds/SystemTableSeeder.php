<?php

use App\Entities\Browser;
use App\Entities\Os;
use App\Entities\System;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $browsers = Browser::all();
        $os = Os::all();
        $now = Carbon::now();

        $systems = $browsers->map(
            function (Browser $browser) use ($os,$now) {
               return factory(System::class, 5)->make([
                    'browser_id' => $browser->id,
                    'os_id' => $os->shuffle()->shuffle()->first()->id,
                    'created_at' => $now->toDateTimeString(),
                ]);
            }
        );

        DB::table('systems')->insert($systems->flatten()->toArray());
    }
}
