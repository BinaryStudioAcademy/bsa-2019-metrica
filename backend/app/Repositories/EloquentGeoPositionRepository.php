<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\GeoPosition;
use App\Repositories\Contracts\GeoPositionRepository;

final class EloquentGeoPositionRepository implements GeoPositionRepository
{
    public function getByParameters(string $country, string $city): ?GeoPosition
    {
        return GeoPosition::where([
            ['country', $country],
            ['city', $city]
        ])->first();
    }

    public function save(GeoPosition $geoPosition): GeoPosition
    {
        $geoPosition->save();
        return $geoPosition;
    }

    public function getById(int $id): GeoPosition
    {
        return GeoPosition::findOrFail($id);
    }
}
