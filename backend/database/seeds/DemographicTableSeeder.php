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
        $geoPositions = GeoPosition::all();

        $demographics = $geoPositions->map(
            function (GeoPosition $geoPosition) {
                factory(Demographic::class, 5)->make([
                    'geo_position_id' => $geoPosition->id,
                ]);
            }
        );

        DB::table('demographic')->insert($demographics->flatten()->toArray());
    }
}
