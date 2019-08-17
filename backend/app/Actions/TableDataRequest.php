<?php

declare(strict_types=1);

namespace App\Actions;

use App\Utils\DatePeriod;
use DateTime;

abstract class TableDataRequest
{
    private $startDate;
    private $endDate;
    private $parameter;

    public function __construct(DatePeriod $datePeriod, string $parameter)
    {
        $this->startDate = $datePeriod->getStartDate();
        $this->endDate = $datePeriod->getEndDate();
        $this->parameter = $parameter;
    }

    public function startDate(): DateTime
    {
        return $this->startDate;
    }

    public function endDate(): DateTime
    {
        return $this->endDate;
    }

    public function parameter(): string
    {
        return $this->parameter;
    }
}