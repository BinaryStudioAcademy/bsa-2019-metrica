<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Actions\ChartDataRequest;
use App\Http\Requests\Session\GetSessionsFilterHttpRequest;

final class GetSessionsRequest extends ChartDataRequest
{
    public static function fromRequest(GetSessionsFilterHttpRequest $request)
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getInterval(),
            $request->getWebsiteId()
        );
    }
}