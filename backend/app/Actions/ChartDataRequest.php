<?php

declare(strict_types=1);

namespace App\Actions;

use App\Utils\DatePeriod;

abstract class ChartDataRequest
{
    private $period;
    private $interval;
    private $websiteId;

    public function __construct(string $startDate, string $endDate, string $interval, int $websiteId)
    {
        $this->period = DatePeriod::createFromTimestamp($startDate, $endDate);
        $this->interval = $interval;
        $this->websiteId = $websiteId;
    }

    public function period(): DatePeriod
    {
        return $this->period;
    }

    public function interval(): string
    {
        return $this->interval;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}