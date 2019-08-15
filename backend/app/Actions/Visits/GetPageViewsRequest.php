<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\Contracts\Visits\PageViewsFilterData;
use App\Http\Requests\Visits\GetPageViewsFilterHttpHttpRequest;
use App\Utils\DatePeriod;

final class GetPageViewsRequest
{
    private $filterData;
    private $interval;

    private function __construct(PageViewsFilterData $filterData, int $interval)
    {
        $this->filterData = $filterData;
        $this->interval = $interval;
    }

    public function getFilterData(): PageViewsFilterData
    {
        return $this->filterData;
    }

    public function getInterval(): int
    {
        return (int) \round($this->interval/1000, 0);
    }

    public static function fromRequest(GetPageViewsFilterHttpHttpRequest $request)
    {

        $period = DatePeriod::createFromTimestamp(
            $request->getStartDate(),
            $request->getEndDate()
        );

        return new static(new \App\Model\Visits\PageViewsFilterData($period), $request->getPeriod());

    }
}
