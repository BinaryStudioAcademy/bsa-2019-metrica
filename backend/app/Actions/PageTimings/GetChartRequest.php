<?php


namespace App\Actions\PageTimings;

use App\Actions\ChartDataRequest;
use App\Http\Requests\PageTimings\PageLoadingChartHttpRequest;

final class GetChartRequest extends ChartDataRequest
{
    public static function fromRequest(PageLoadingChartHttpRequest $request)
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getPeriod()
        );
    }
}

