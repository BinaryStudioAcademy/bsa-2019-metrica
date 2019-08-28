<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Actions\TableDataRequest;
use App\Http\Requests\Visitor\GetTableVisitorsByParameterHttpRequest;

class GetVisitorsBounceRateByParameterRequest extends TableDataRequest
{
    public static function fromRequest(GetTableVisitorsByParameterHttpRequest $request)
    {
        return new static (
            $request->startDate(),
            $request->endDate(),
            $request->parameter()
        );
    }
}