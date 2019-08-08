<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\GeoPosition;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(GeoPosition::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'country' => $faker->country,
        'city' => $faker->city,
        'created_at' => $now->toDateTimeString(),
    ];
});
