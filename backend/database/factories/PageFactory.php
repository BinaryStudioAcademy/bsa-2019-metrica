<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Page;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Page::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'name' => $faker->name,
        'url' => $faker->url,
        'previews' => $faker->numberBetween(1, 100),
        'website_id' => \App\Entities\Website::query()->inRandomOrder()->first()->id,
        'created_at' => $now->toDateTimeString(),
    ];
});
