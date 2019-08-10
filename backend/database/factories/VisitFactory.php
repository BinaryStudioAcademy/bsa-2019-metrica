<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Visit;
use Faker\Generator as Faker;

$factory->define(Visit::class, function (Faker $faker) {
    $now = \Illuminate\Support\Carbon::now();

    return [
        'visit_time' => $faker->unixTime,
        'ip_address' => $faker->ipv4,
        'session_id' => \App\Entities\Session::query()->inRandomOrder()->first()->id,
        'page_id' => \App\Entities\Page::query()->inRandomOrder()->first()->id,
        'visitor_id' => \App\Entities\Visitor::query()->inRandomOrder()->first()->id,
        'device_id' => \App\Entities\Device::query()->inRandomOrder()->first()->id,
        'created_at' => $now->toDateTimeString(),
    ];
});
