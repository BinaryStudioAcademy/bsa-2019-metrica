<?php

declare(strict_types=1);

namespace App\Actions\GeoLocation;

use Illuminate\Support\Collection;

final class GetAllVisitorsCountResponse
{
    private $allVisitorsCount;

    public function __construct(Collection $allVisitorsCount)
    {
        $this->allVisitorsCount = $allVisitorsCount;
    }

    public function allVisitorsCount(): Collection
    {
        return $this->allVisitorsCount;
    }
}