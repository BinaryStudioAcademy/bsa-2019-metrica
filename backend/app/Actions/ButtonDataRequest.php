<?php

declare(strict_types=1);

namespace App\Actions;

use App\Utils\DatePeriod;

abstract class ButtonDataRequest
{
    private $period;

    public function __construct(string $startDate, string $endDate)
    {
        $this->period = DatePeriod::createFromTimestamp($startDate, $endDate);
    }

    public function period(): DatePeriod
    {
        return $this->period;
    }
}