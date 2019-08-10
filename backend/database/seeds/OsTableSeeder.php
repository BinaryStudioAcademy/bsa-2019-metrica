<?php

use App\Entities\Os;
use Illuminate\Database\Seeder;

class OsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Os::class, 5)->create();
    }
}
