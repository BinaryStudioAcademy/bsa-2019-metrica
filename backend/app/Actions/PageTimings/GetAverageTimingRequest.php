<?php

declare(strict_types=1);

namespace App\Actions\PageTimings;

use App\Actions\ButtonDataRequest;
use App\Http\Requests\System\FilterByPeriodHttpRequest;

class GetAverageTimingRequest extends ButtonDataRequest
{
    public static function fromRequest(FilterByPeriodHttpRequest $request)
    {
        return new static (
            $request->getStartDate(),
            $request->getEndDate()
        );
    }
}
