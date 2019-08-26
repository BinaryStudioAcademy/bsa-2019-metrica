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
        ?int $newVisitorsCount,
        int $sessionsCount,
        int $bounceRate,
        int $avgSessionTime
    ) {
        $this->country = $country;
        $this->allVisitorsCount = $allVisitorsCount;
        $this->newVisitorsCount = $newVisitorsCount;
        $this->sessionsCount = $sessionsCount;
        $this->bounceRate = $bounceRate;
        $this->avgSessionTime = $avgSessionTime;
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

    public function sessionsCount(): int
    {
        return $this->sessionsCount;
    }

    public function bounceRate(): int
    {
        return $this->bounceRate;
    }

    public function avgSessionTime(): int
    {
        return $this->avgSessionTime;
    }
}