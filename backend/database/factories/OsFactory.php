<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Os;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Os::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'name' => $faker->name,
        'created_at' => $now->toDateTimeString(),
    ];
});
