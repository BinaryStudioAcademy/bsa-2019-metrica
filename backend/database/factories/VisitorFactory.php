<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Visitor;
use App\Entities\Website;
use Faker\Generator as Faker;

$factory->define(Visitor::class, function (Faker $faker) {
    $date = $faker->dateTimeThisMonth();
    return [
        'visitor_type' => $faker->text(10),
        'website_id' => Website::inRandomOrder()->first()->id,
        'updated_at' => $date,
        'created_at' => $date
    ];
});
