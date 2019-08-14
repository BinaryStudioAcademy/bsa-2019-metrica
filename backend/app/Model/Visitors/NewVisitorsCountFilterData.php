<?php


namespace App\Model\Visitors;


use App\Contracts\Common\DatePeriod;
use App\Contracts\Visitors\NewVisitorsCountFilterData as INewVisitorsCountFilterData;

class NewVisitorsCountFilterData implements INewVisitorsCountFilterData
{
    private $datePeriod;

    public function __construct(DatePeriod $datePeriod)
    {
        $this->datePeriod = $datePeriod;
    }

    public function getStartDate(): \DateTime
    {
        return $this->datePeriod->getStartDate();
    }

    public function getEndDate(): \DateTime
    {
        return $this->datePeriod->getEndDate();
    }
}
