<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\GeoPosition;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\Visit;
use App\Entities\Visitor;
use Faker\Generator as Faker;

$factory->define(Visit::class, function (Faker $faker) {
    return [
        'visit_time' => $faker->dateTimeBetween('-1 year', 'now'),
        'ip_address' => $faker->ipv4,
        'session_id' => Session::inRandomOrder()->first()->id,
        'page_id' => Page::inRandomOrder()->first()->id,
        'visitor_id' => Visitor::inRandomOrder()->first()->id,
        'geo_position_id' => GeoPosition::inRandomOrder()->first()->id,
    ];
});
