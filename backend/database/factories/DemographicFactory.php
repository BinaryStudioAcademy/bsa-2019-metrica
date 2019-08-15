<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Demographic;
use App\Entities\GeoPosition;
use Faker\Generator as Faker;

$factory->define(Demographic::class, function (Faker $faker) {
    return [
        'language' => $faker->languageCode,
        'geo_position_id' => GeoPosition::inRandomOrder()->first()->id,
    ];
});
