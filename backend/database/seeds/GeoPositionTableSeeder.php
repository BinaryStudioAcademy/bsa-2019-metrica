<?php

use App\Entities\GeoPosition;
use Illuminate\Database\Seeder;

class GeoPositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(GeoPosition::class, 10)->create();
    }
}
