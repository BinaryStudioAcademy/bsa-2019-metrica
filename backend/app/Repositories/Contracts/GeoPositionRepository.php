<?php

namespace App\Repositories\Contracts;

use App\Entities\GeoPosition;

interface GeoPositionRepository
{
    public function getByParameters(string $country, string $city): ?GeoPosition;

    public function save(GeoPosition $geoPosition): GeoPosition;

    public function getById(int $id): GeoPosition;

}
