<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\Actions\ChartDataRequest;
use App\Http\Requests\Visit\GetPageViewsAvgTimeHttpRequest;

final class GetPageViewsAvgTimeRequest extends ChartDataRequest
{
    public static function fromRequest(GetPageViewsAvgTimeHttpRequest $request)
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getInterval()
        );
    }
}
