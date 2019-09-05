<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           // DefaultUserAndWebsiteSeeder::class,
           // PageTableSeeder::class,
            //SystemTableSeeder::class,
            //GeoPositionTableSeeder::class,
            //InitVisitorsSeeder::class,
            ErrorsTableSeeder::class,
        ]);
    }
}
