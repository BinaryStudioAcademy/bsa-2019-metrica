<?php


namespace App\Model\Visitors;

use App\Contracts\Common\DatePeriod;
use App\Contracts\Visitors\VisitorsBounceRateFilterData as IVisitorsBounceRateFilterData;

class VisitorsBounceRateFilterData implements IVisitorsBounceRateFilterData
{
    private $datePeriod;
    private $timeFrame;
    private $websiteId;

    public function __construct(DatePeriod $datePeriod, int $timeFrame, int $websiteId)
    {
        $this->datePeriod = $datePeriod;
        $this->timeFrame = $timeFrame;
        $this->websiteId = $websiteId;
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

    public function websiteId(): int
    {
        return $this->websiteId;
    }

}
