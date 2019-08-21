<?php


namespace App\Model\Sessions;

use App\Contracts\Common\DatePeriod;
use App\Contracts\Sessions\AverageSessionByIntervalFilterData as IAverageSessionByIntervalFilterData;

class AverageSessionByIntervalFilterData implements IAverageSessionByIntervalFilterData
{
    private $datePeriod;
    private $timeFrame;

    public function __construct(DatePeriod $datePeriod, int $timeFrame)
    {
        $this->datePeriod = $datePeriod;
        $this->timeFrame = $timeFrame;
    }

    public function getStartDate(): \DateTime
    {
        return $this->datePeriod->getStartDate();
    }

    public function getEndDate(): \DateTime
    {
        return $this->datePeriod->getEndDate();
    }

    public function getTimeFrame(): int
    {
        return $this->timeFrame;
    }
}
