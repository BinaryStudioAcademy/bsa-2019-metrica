<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Actions\TableDataRequest;
use App\Http\Requests\Session\GetAvgSessionsTimeByParameterHttpRequest;

final class GetAvgSessionTimeByParameterRequest extends TableDataRequest
{
    public static function fromRequest(GetAvgSessionsTimeByParameterHttpRequest $request): self
    {
        return new static(
            $request->startDate(),
            $request->endDate(),
            $request->parameter(),
            $request->websiteId()
        );
    }
}