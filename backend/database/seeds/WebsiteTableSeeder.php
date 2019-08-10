<?php

use App\Entities\User;
use App\Entities\Website;
use Carbon\Carbon;
use Faker\Factory as Faker;
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
        $now = Carbon::now();
        $users = User::all();
        $faker = Faker::create();
        $websites = $users->map(
            function (User $user) use ($faker, $now){
                return factory(Website::class, 1)->make([
                    'user_id' => $user->id,
                    'name' => $faker->unique()->name,
                    'domain' => "http://". $faker->unique()->name .".com",
                    'created_at' => $now->toDateTimeString()
                ]);
            }
        );

        DB::table('websites')->insert($websites->flatten()->toArray());
    }
}
