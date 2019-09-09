<?php

use App\Entities\User;
use App\Entities\Website;
use Illuminate\Database\Seeder;

class UserAndWebsitesWithDifferentRolesSeeder extends Seeder
{
    public function run()
    {
        try {
            $firstUser = User::whereEmail('info@metrica.fun')->first();
            $website = $firstUser->websites()->wherePivot('role', 'owner')->first();

            $secondUser = factory(User::class)->create();
            $thirdUser = factory(User::class)->create();

            $secondUser->websites()->attach($website->id, ['role' => 'member']);
            $thirdUser->websites()->attach($website->id, ['role' => 'member']);

            $secondWebsite = factory(Website::class)->create();
            $secondUser->websites()->attach($secondWebsite->id, ['role' => 'owner']);
        } catch (\Illuminate\Database\QueryException $exception) {
            //skip duplicate exception
        }
    }
}
