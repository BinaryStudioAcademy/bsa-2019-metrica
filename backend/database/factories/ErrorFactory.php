<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Entities\Visitor;
use App\Entities\Error;

$factory->define(Error::class, function (Faker $faker) {
    $visitor = Visitor::inRandomOrder()->first();
    $website = $visitor->website;

    return [
        'message' => $faker->sentence(5),
        'stack_trace' => $faker->text(100),
        'page_id' => $website->pages->random()->id,
        'visitor_id' => $visitor->id,
    ];
});