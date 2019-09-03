<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Actions\ChartDataRequest;
use App\Http\Requests\Api\GetBounceRateChartHttpRequest;

final class GetBounceRateChartByDateRangeRequest extends ChartDataRequest
{
    public static function fromRequest(GetBounceRateChartHttpRequest $request)
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getPeriod(),
            $request->websiteId()
        );
    }
}