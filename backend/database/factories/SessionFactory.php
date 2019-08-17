<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Demographic;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\Visitor;
use App\Entities\Website;
use App\Entities\Device;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Session::class, function (Faker $faker) {
    return [
        'start_session' => (Carbon::now())->toDateString(),
        'visitor_id' => Visitor::inRandomOrder()->first()->id,
        'entrance_page_id' => Page::inRandomOrder()->first()->id,
        'demographic_id' => Demographic::inRandomOrder()->first()->id,
        'system_id' => System::inRandomOrder()->first()->id,
        'device_id' => Device::inRandomOrder()->first()->id,
        'website_id' => Website::inRandomOrder()->first()->id,
    ];
});
