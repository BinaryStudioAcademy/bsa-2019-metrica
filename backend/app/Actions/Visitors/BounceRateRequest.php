<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Http\Requests\Visitor\GetVisitorsBounceRateHttpRequest;
use App\Model\Visitors\VisitorsBounceRateFilterData;
use App\Utils\DatePeriod;

final class BounceRateRequest
{
    private $filterData;

    private function __construct(VisitorsBounceRateFilterData $filterData)
    {
        $this->filterData = $filterData;
    }

    public function getFilterData(): VisitorsBounceRateFilterData
    {
        return $this->filterData;
    }

    public static function fromRequest(GetVisitorsBounceRateHttpRequest $request): self
    {
        $period = DatePeriod::createFromTimestamp(
            $request->getStartDate(),
            $request->getEndDate()
        );
        return new static(new VisitorsBounceRateFilterData(
            $period,
            $request->getPeriod(),
            $request->websiteId()
        ));
    }
}
