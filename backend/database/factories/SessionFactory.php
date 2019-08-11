<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Demographic;
use App\Entities\Device;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\Visitor;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Session::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'start_session' => $faker->unixTime,
        'end_session' => $faker->unixTime,
        'visitor_id' => Visitor::query()->inRandomOrder()->first()->id,
        'entrance_page_id' => Page::query()->inRandomOrder()->first()->id,
        'demographic_id' => Demographic::query()->inRandomOrder()->first()->id,
        'device_id' => Device::query()->inRandomOrder()->first()->id,
        'system_id' => System::query()->inRandomOrder()->first()->id,
        'created_at' => $now->toDateTimeString(),
    ];
});
