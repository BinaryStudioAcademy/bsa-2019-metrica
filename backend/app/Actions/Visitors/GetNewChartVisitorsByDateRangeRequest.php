<?php


namespace App\Actions\Visitors;

use App\Actions\ChartDataRequest;
use App\Http\Requests\Api\GetNewChartVisitorsHttpRequest;

class GetNewChartVisitorsByDateRangeRequest extends ChartDataRequest
{
    public static function fromRequest(GetNewChartVisitorsHttpRequest $request)
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getPeriod()
        );
    }
}
