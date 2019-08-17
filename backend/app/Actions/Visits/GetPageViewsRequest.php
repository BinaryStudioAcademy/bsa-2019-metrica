<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\Contracts\Common\DatePeriod;
use App\Http\Requests\Visits\GetPageViewsFilterHttpRequest;


final class GetPageViewsRequest
{
    private $filterData;
    private $interval;

    private function __construct(DatePeriod $filterData, float $interval)
    {
        $this->filterData = $filterData;
        $this->interval = $interval;
    }

    public function getFilterData(): DatePeriod
    {
        return $this->filterData;
    }

    public function getInterval(): int
    {
        return (int) \round($this->interval/1000, 0);
    }

    public static function fromRequest(GetPageViewsFilterHttpRequest $request)
    {
        $period = \App\Utils\DatePeriod::createFromTimestamp(
            $request->getStartDate(),
            $request->getEndDate()
        );

        return new static(
            new \App\Model\Visits\PageViewsFilterData($period),
            $request->getPeriod()
        );
    }
}
