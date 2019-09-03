<?php

declare(strict_types=1);

namespace App\Actions\PageTimings;

use App\Actions\TableDataRequest;
use App\Http\Request\PageTimingTableHttpRequest;

class GetAverageTimingRequest extends TableDataRequest
{
    public static function fromRequest(PageTimingTableHttpRequest $request)
    {
        return new static (
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getParameter()
        );
    }
}
