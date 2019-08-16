<?php

use App\Entities\Browser;
use App\Entities\Os;
use App\Entities\System;
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

        $systems = $browsers->map(
            function (Browser $browser) use ($os) {
                return factory(System::class, 5)->make([
                    'browser_id' => $browser->id,
                    'os_id' => $os->shuffle()->shuffle()->first()->id
                ]);
            }
        );

        DB::table('systems')->insert($systems->flatten()->toArray());
    }
}
