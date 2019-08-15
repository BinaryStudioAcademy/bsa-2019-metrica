<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Page;
use App\Entities\Website;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'url' => $faker->url,
        'previews' => $faker->numberBetween(1, 100),
        'website_id' => Website::inRandomOrder()->first()->id,
    ];
});
