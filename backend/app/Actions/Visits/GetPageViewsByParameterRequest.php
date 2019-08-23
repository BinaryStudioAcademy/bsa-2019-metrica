<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Actions\TableDataRequest;
use App\Http\Requests\Visit\GetTableVisitsByParameterHttpRequest;

final class GetPageViewsByParameterRequest extends TableDataRequest
{
    public static function fromRequest(GetTableVisitsByParameterHttpRequest $request)
    {
        return new static(
            $request->startDate(),
            $request->endDate(),
            $request->parameter()
        );
    }
}