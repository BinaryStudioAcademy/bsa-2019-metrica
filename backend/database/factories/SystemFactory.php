<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Browser;
use App\Entities\Os;
use App\Entities\System;
use Faker\Generator as Faker;

$factory->define(System::class, function (Faker $faker) {
    return [
        'browser_id' => Browser::inRandomOrder()->first()->id,
        'os_id' => Os::inRandomOrder()->first()->id,
        'screen_resolution' => $faker->numberBetween(320, 960) . 'x' . $faker->numberBetween(480, 1920),
    ];
});
