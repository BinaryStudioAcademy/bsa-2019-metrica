<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Demographic;
use App\Entities\GeoPosition;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Demographic::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'language' => $faker->languageCode,
        'geo_position_id' => GeoPosition::query()->inRandomOrder()->first()->id,
        'created_at' => $now->toDateTimeString(),
    ];
});
