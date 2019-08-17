<?php
declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Contracts\Visitors\NewVisitorsCountFilterData;
use App\Http\Requests\Api\GetNewVisitorCountFilterHttpRequest;
use App\Utils\DatePeriod;

final class GetNewestCountRequest
{
    private $filterData;

    private function __construct(NewVisitorsCountFilterData $filterData)
    {
        $this->filterData = $filterData;
    }

    public function getFilterData(): NewVisitorsCountFilterData
    {
        return $this->filterData;
    }

    public static function fromRequest(GetNewVisitorCountFilterHttpRequest $request): self
    {
        $period = DatePeriod::createFromTimestamp(
            $request->getStartDate(),
            $request->getEndDate()
        );
        return new static(new \App\Model\Visitors\NewVisitorsCountFilterData($period));
    }
}
