<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Contracts\Visitors\NewVisitorsCountFilterData;
use App\Http\Requests\Visitor\GetNewVisitorCountFilterHttpRequest;
use App\Utils\DatePeriod;

final class GetNewestCountRequest
{
    private $filterData;
    private $websiteId;

    private function __construct(NewVisitorsCountFilterData $filterData, int $websiteId)
    {
        $this->filterData = $filterData;
        $this->websiteId = $websiteId;
    }

    public function getFilterData(): NewVisitorsCountFilterData
    {
        return $this->filterData;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }

    public static function fromRequest(GetNewVisitorCountFilterHttpRequest $request): self
    {
        $period = DatePeriod::createFromTimestamp(
            $request->getStartDate(),
            $request->getEndDate()
        );
        return new static(new \App\Model\Visitors\NewVisitorsCountFilterData($period), $request->getWebsiteId());
    }
}
