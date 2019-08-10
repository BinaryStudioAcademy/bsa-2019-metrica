<?php

use App\Entities\Browser;
use Illuminate\Database\Seeder;

class BrowserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Browser::class, 5)->create();
    }
}
