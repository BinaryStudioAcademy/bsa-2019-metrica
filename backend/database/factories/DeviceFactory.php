<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Device;
use Faker\Generator as Faker;

$factory->define(Device::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
