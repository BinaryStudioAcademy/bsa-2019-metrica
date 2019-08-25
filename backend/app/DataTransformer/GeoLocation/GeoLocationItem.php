<?php

declare(strict_types=1);

namespace App\DataTransformer\GeoLocation;

final class GeoLocationItem
{
    private $country;
    private $allVisitorsCount;
    private $newVisitorsCount;
    private $sessionsCount;
    private $bounceRate;
    private $avgSessionTime;

    public function __construct(
        string $country,
        int $allVisitorsCount,
        ?int $newVisitorsCount
    ) {
        $this->country = $country;
        $this->allVisitorsCount = $allVisitorsCount;
        $this->newVisitorsCount = $newVisitorsCount;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function allVisitorsCount(): int
    {
        return $this->allVisitorsCount;
    }

    public function newVisitorsCount(): ?int
    {
        return $this->newVisitorsCount;
    }

    public function sessionsCount()
    {
        return $this->sessionsCount;
    }

    public function bounceRate()
    {
        return $this->bounceRate;
    }

    public function avgSessionTime()
    {
        return $this->avgSessionTime;
    }
}