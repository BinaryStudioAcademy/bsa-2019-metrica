<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Entities\Error;

class ErrorsTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::query()->where('email', '=', 'info@metrica.fun')->first();
        $ueserWebsite = $user->websites()->wherePivot('role', 'owner')->first();

        for ($i = 0; $i < 5; $i++) {
            $visit = $ueserWebsite->visits->random();
            factory(Error::class, 5)->create([
                'visitor_id' => $visit->visitor->id,
                'page_id' => $visit->page->id
            ]);
        }
    }
}
