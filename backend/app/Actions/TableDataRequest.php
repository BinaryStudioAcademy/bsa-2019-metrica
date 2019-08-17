<?php

declare(strict_types=1);

namespace App\Actions;

use App\Utils\DatePeriod;

abstract class TableDataRequest
{
    private $period;
    private $parameter;

    public function __construct(string $startDate, string $endDate, string $parameter)
    {
        $this->period = DatePeriod::createFromTimestamp($startDate, $endDate);
        $this->parameter = $parameter;
    }

    public function period(): DatePeriod
    {
        return $this->period;
    }

    public function parameter(): string
    {
        return $this->parameter;
    }
}