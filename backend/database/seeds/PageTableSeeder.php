<?php

use App\Entities\Page;
use App\Entities\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::query()->where('email', '=', 'info@metrica.fun')->first();

        $userWebsite = $this->user->websites->filter(function($website) {
            return $website->pivot->role === 'owner';
        })->first();

        $pages = factory(Page::class, 5)->make([
            'website_id' => $userWebsite->id,
        ]);

        DB::table('pages')->insert($pages->flatten()->toArray());
    }
}
