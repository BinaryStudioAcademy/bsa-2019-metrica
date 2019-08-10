<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Device;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Device::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'name' => $faker->name,
        'created_at' => $now->toDateTimeString(),
    ];
});
