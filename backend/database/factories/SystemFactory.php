<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Browser;
use App\Entities\Os;
use App\Entities\System;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(System::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'browser_id' => Browser::query()->inRandomOrder()->first()->id,
        'os_id' => Os::query()->inRandomOrder()->first()->id,
        'screen_resolution' => $faker->numberBetween(320, 960) . 'x' . $faker->numberBetween(480, 1920),
        'created_at' => $now->toDateTimeString(),
    ];
});
