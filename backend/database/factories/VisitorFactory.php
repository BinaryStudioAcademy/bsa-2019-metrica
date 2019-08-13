<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Visitor;
use App\Entities\Website;
use Faker\Generator as Faker;

$factory->define(Visitor::class, function (Faker $faker) {
    return [
        'visitor_type' => $faker->text(10),
        'website_id' => Website::inRandomOrder()->first()->id,
    ];
});
