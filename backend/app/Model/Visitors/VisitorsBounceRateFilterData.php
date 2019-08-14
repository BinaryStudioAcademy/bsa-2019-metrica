<?php


namespace App\Model\Visitors;


use App\Contracts\Common\DatePeriod;
use App\Contracts\Visitors\VisitorsBounceRateFilterData as IVisitorsBounceRateFilterData;

class VisitorsBounceRateFilterData implements IVisitorsBounceRateFilterData
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
