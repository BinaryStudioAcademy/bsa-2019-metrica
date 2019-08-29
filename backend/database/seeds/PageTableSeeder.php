<?php

use App\Entities\Page;
use App\Entities\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::query()->where('email', '=', 'info@metrica.fun' )->first();

        $pages = factory(Page::class, 5)->make([
            'website_id' => $user->website->id,
        ]);

        DB::table('pages')->insert($pages->flatten()->toArray());
    }
}
