<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\System;
use Faker\Generator as Faker;

$factory->define(System::class, function (Faker $faker) {
    $resolutions = [
        'width' => [
            3840,
            3440,
            2560,
            2048,
            1920,
            1440,
            1280,
            1024,
            800
        ],
        'height' => [
            2160,
            1440,
            1080,
            1080,
            1440,
            900,
            1024,
            768,
            600
        ]
    ];

    $randomResolution = $faker->numberBetween(0, count($resolutions['width']) - 1);

    return [
        'name' => $faker->word,
        'os' => $faker->randomElement([
            $faker->windowsPlatformToken,
            $faker->linuxPlatformToken,
            $faker->macPlatformToken
        ]),
        'browser' => $faker->randomElement([
            $faker->chrome,
            $faker->safari,
            $faker->firefox,
            $faker->internetExplorer
        ]),
        'device' => $faker->randomElement([
            'tablet',
            'desktop',
            'mobile'
        ]),
        'resolution_width' => $resolutions['width'][$randomResolution],
        'resolution_height' => $resolutions['height'][$randomResolution],
    ];
});
