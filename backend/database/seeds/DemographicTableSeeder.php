<?php

use App\Entities\Demographic;
use App\Entities\GeoPosition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemographicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Demographic::class, 5)->create();
    }
}
