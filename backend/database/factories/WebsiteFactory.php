<?php
declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\User;
use App\Entities\Website;
use Faker\Generator as Faker;

$factory->define(Website::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'domain' => $faker->domainName,
        'single_page' => $faker->boolean(),
        'tracking_number' => $faker->numberBetween(1, 200)
    ];
});
