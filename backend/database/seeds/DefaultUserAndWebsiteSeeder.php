<?php

use App\Entities\User;
use App\Entities\Website;
use Illuminate\Database\Seeder;

class DefaultUserAndWebsiteSeeder extends Seeder
{
    public function run()
    {
        try{
            $user = factory(User::class)->create([
                'email' => 'info@metrica.fun',
                'is_activate' => 1,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);

            factory(Website::class, 1)->create([
                'user_id' => $user->id,
                'name' => 'Metrica',
                'domain' => "https://metrica.fun"
            ]);
        }catch (\Illuminate\Database\QueryException $exception){
            //skip duplicate exception
        }

    }
}
