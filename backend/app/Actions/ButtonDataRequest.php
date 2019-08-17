<?php

declare(strict_types=1);

namespace App\Actions;

use App\Utils\DatePeriod;
use DateTime;

abstract class ButtonDataRequest
{
    private $startDate;
    private $endDate;

    public function __construct(DatePeriod $datePeriod)
    {
        $this->startDate = $datePeriod->getStartDate();
        $this->endDate = $datePeriod->getEndDate();
    }

    public function startDate(): DateTime
    {
        return $this->startDate;
    }

    public function endDate(): DateTime
    {
        return $this->endDate;
    }
}