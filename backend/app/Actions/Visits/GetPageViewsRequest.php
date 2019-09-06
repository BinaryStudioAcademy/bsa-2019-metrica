<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Actions\ChartDataRequest;
use App\Http\Requests\Visit\GetPageViewsFilterHttpRequest;

final class GetPageViewsRequest extends ChartDataRequest
{
    public static function fromRequest(GetPageViewsFilterHttpRequest $request)
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getPeriod(),
            $request->websiteId()
        );
    }
}
