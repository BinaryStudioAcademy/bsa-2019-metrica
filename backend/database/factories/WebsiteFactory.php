<?php
declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\TrackingInfo;
use App\Entities\User;
use App\Entities\Website;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Website::class, function (Faker $faker) {
    $now = Carbon::now();

    return [
        'name' => $faker->name,
        'domain' => $faker->domainName,
        'single_page' => $faker->boolean(),
        'user_id' => User::query()->inRandomOrder()->first()->id,
        'tracking_number' => $faker->numberBetween(1, 200),
        'created_at' => $now->toDateTimeString(),
    ];
});
