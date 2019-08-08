<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Browser;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Browser::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'name' => $faker->name,
        'created_at' => $now->toDateTimeString(),
    ];
});
