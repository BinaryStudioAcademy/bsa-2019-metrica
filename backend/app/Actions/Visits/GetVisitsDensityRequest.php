<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use Carbon\Carbon;

final class GetVisitsDensityRequest
{
    private $startDate;
    private $endDate;
    private $timeZone;

    public function __construct(string $startDate, string $endDate, string $timeZone)
    {
        $this->startDate = Carbon::createFromTimestamp($startDate)->toDateTimeString();
        $this->endDate = Carbon::createFromTimestamp($endDate)->toDateTimeString();
        $this->timeZone = $timeZone;
    }

    public function startDate(): string
    {
        return $this->startDate;
    }

    public function endDate(): string
    {
        return $this->endDate;
    }

    public function getTimeZone(): string
    {
        return $this->timeZone;
    }
}
