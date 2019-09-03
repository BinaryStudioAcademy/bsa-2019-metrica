<?php

declare(strict_types=1);

namespace App\Actions;

use App\Utils\DatePeriod;

abstract class ButtonDataRequest
{
    private $period;
    private $websiteId;

    public function __construct(string $startDate, string $endDate, int $websiteId)
    {
        $this->period = DatePeriod::createFromTimestamp($startDate, $endDate);
        $this->websiteId = $websiteId;
    }

    public function period(): DatePeriod
    {
        return $this->period;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}