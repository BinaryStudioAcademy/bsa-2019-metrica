<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Actions\ChartDataRequest;
use App\Http\Requests\Visit\GetUniquePageViewsChartHttpRequest;

class GetUniquePageViewsChartRequest extends ChartDataRequest
{
    public static function fromRequest(GetUniquePageViewsChartHttpRequest $request): self
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getInterval(),
            $request->websiteId()
        );
    }
}
