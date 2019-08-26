<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\Visitor;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Session::class, function (Faker $faker) {
    $visitor = Visitor::inRandomOrder()->first();

    return [
        'start_session' => Carbon::yesterday()->toDateTimeString(),
        'visitor_id' => $visitor->id,
        'entrance_page_id' => Page::inRandomOrder()->first()->id,
        'language' => $faker->languageCode,
        'system_id' => System::inRandomOrder()->first()->id,
        'website_id' => $visitor->website->id,
        'end_session' => Carbon::now()->toDateTimeString(),
    ];
});
