<?php


namespace App\Model\Visits;

use App\Contracts\Common\DatePeriod;
use App\Contracts\Visits\PageViewsFilterData as IPageViewsFilterData;

class PageViewsFilterData implements IPageViewsFilterData
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
