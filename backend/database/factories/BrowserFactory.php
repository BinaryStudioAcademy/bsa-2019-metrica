<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Browser;
use Faker\Generator as Faker;

$factory->define(Browser::class, function (Faker $faker) {
    return [
        'name' => random_int(0, 1) ? $faker->chrome : random_int(0, 1)
            ? $faker->safari : random_int(0, 1)
                ? $faker->firefox : $faker->internetExplorer,
    ];
});
