<?php

use App\Entities\Visitor;
use App\Entities\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $websites = Website::all();

        $visitors = $websites->map(
            function (Website $website) {
                return factory(Visitor::class, 5)->make([
                    'website_id' => $website->id,
                ]);
            }
        );

        DB::table('visitors')->insert($visitors->flatten()->toArray());
    }
}
