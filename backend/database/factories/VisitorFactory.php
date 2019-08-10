<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Visitor;
use App\Entities\Website;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Visitor::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'visitor_type' => $faker->text(10),
        'website_id' => Website::query()->inRandomOrder()->first()->id,
        'created_at' => $now->toDateTimeString(),
    ];
});
