<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Browser;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Browser::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'name' => random_int(0, 1) ? $faker->chrome : random_int(0, 1)
            ? $faker->safari : random_int(0, 1)
                ? $faker->firefox : $faker->internetExplorer,
        'created_at' => $now->toDateTimeString(),
    ];
});
