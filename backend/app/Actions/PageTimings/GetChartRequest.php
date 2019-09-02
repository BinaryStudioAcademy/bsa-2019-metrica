<?php


namespace App\Actions\PageTimings;

use App\Actions\ChartDataRequest;
use App\Http\Requests\PageTimings\PageTimingChartHttpRequest;

final class GetChartRequest extends ChartDataRequest
{
    public static function fromRequest(PageTimingChartHttpRequest $request)
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getPeriod()
        );
    }
}

