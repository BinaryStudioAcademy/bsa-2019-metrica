<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\Actions\ChartDataRequest;
use App\Http\Requests\Visit\GetPageViewsChartAvgTimeHttpRequest;

final class GetPageViewsChartAvgTimeRequest extends ChartDataRequest
{
    public static function fromRequest(GetPageViewsChartAvgTimeHttpRequest $request)
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getInterval()
        );
    }
}
