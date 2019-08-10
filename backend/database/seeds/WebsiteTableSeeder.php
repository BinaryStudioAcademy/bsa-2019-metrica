<?php

use App\Entities\User;
use App\Entities\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $websites = $users->map(
            function (User $user) {
                return factory(Website::class, 1)->make([
                    'user_id' => $user->id,
                ]);
            }
        );

        DB::table('websites')->insert($websites->flatten()->toArray());
    }
}
