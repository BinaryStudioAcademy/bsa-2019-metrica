<?php

declare(strict_types=1);

namespace App\Actions\GeoLocation;

use Carbon\Carbon;

final class GetGeoLocationItemsRequest
{
    private $startDate;
    private $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = Carbon::createFromTimestamp($startDate)->toDateTimeString();
        $this->endDate = Carbon::createFromTimestamp($endDate)->toDateTimeString();
    }

    public function startDate(): string
    {
        return $this->startDate;
    }

    public function endDate(): string
    {
        return $this->endDate;
    }
}