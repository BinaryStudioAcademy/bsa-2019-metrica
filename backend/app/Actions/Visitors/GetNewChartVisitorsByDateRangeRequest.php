<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Actions\ChartDataRequest;
use App\Http\Requests\Visitor\GetNewChartVisitorsHttpRequest;

final class GetNewChartVisitorsByDateRangeRequest extends ChartDataRequest
{
    public static function fromRequest(GetNewChartVisitorsHttpRequest $request)
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getPeriod(),
            $request->websiteId()
        );
    }
}
