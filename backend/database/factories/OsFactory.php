<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Os;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Os::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'name' => random_int(0, 1) ? $faker->windowsPlatformToken : random_int(0, 1)
            ? $faker->linuxPlatformToken : $faker->macPlatformToken,
        'created_at' => $now->toDateTimeString(),
    ];
});
