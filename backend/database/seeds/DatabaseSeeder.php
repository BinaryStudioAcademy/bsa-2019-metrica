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
            UserTableSeeder::class,
            WebsiteTableSeeder::class,
            VisitorTableSeeder::class,
            PageTableSeeder::class,
            DeviceTableSeeder::class,
            BrowserTableSeeder::class,
            OsTableSeeder::class,
            SystemTableSeeder::class,
            GeoPositionTableSeeder::class,
            SessionTableSeeder::class,
            VisitTableSeeder::class
        ]);
    }
}
