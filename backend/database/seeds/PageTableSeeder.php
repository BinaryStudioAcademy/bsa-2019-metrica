<?php

use App\Entities\Page;
use App\Entities\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $websites = Website::all();

        $pages = $websites->map(
            function (Website $website) {
                return factory(Page::class, 5)->make([
                    'website_id' => $website->id,
                ]);
            }
        );

        DB::table('pages')->insert($pages->flatten()->toArray());
    }
}
