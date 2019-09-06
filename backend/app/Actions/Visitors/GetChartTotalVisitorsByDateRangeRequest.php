<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Actions\ChartDataRequest;
use App\Http\Requests\Visitor\GetChartTotalVisitorsByDateRangeHttpRequest;

final class GetChartTotalVisitorsByDateRangeRequest extends ChartDataRequest
{
    public static function fromRequest(GetChartTotalVisitorsByDateRangeHttpRequest $request)
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getPeriod(),
            $request->websiteId()
        );
    }
}