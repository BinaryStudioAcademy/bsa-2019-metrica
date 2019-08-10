<?php

use App\Entities\User;
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
        factory(User::class, 10)->create();
        $this->call(WebsiteTableSeeder::class);
        $this->call(VisitorTableSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(DeviceTableSeeder::class);
        $this->call(BrowserTableSeeder::class);
        $this->call(OsTableSeeder::class);
        $this->call(SystemTableSeeder::class);
        $this->call(GeoPositionTableSeeder::class);
    }
}
