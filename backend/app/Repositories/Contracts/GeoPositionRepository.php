<?php

namespace App\Repositories\Contracts;

use App\Entities\GeoPosition;

interface GeoPositionRepository
{
    public function getByParameters(string $country, string $city): ?GeoPosition;
}
