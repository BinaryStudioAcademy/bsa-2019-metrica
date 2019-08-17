<?php

declare(strict_types=1);

namespace App\Actions;

use App\Utils\DatePeriod;
use DateTime;

abstract class ChartDataRequest
{
    private $startDate;
    private $endDate;
    private $interval;

    public function __construct(DatePeriod $datePeriod, string $interval)
    {
        $this->startDate = $datePeriod->getStartDate();
        $this->endDate = $datePeriod->getEndDate();
        $this->interval = $interval;
    }

    public function startDate(): DateTime
    {
        return $this->startDate;
    }

    public function endDate(): DateTime
    {
        return $this->endDate;
    }

    public function interval(): string
    {
        return $this->interval;
    }
}