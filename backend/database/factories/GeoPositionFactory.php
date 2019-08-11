<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\GeoPosition;
use Faker\Generator as Faker;

$factory->define(GeoPosition::class, function (Faker $faker) {
    return [
        'country' => $faker->country,
        'city' => $faker->city,
    ];
});
