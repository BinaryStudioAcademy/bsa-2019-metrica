<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Language;
use Faker\Generator as Faker;

$factory->define(Language::class, function (Faker $faker) {
    return [
        'language' => $faker->languageCode,
    ];
});
