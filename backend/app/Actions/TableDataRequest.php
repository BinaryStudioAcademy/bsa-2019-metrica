<?php

declare(strict_types=1);

namespace App\Actions;

use App\Utils\DatePeriod;

abstract class TableDataRequest
{
    private $period;
    private $parameter;
    private $websiteId;

    public function __construct(string $startDate, string $endDate, string $parameter, int $websiteId)
    {
        $this->period = DatePeriod::createFromTimestamp($startDate, $endDate);
        $this->parameter = $parameter;
        $this->websiteId = $websiteId;
    }

    public function period(): DatePeriod
    {
        return $this->period;
    }

    public function parameter(): string
    {
        return $this->parameter;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}