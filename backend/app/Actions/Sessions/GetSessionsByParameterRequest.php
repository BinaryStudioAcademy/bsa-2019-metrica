<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Actions\TableDataRequest;
use App\Http\Requests\Session\GetSessionsByParameterHttpRequest;

class GetSessionsByParameterRequest extends TableDataRequest
{
    public static function fromRequest(GetSessionsByParameterHttpRequest $request)
    {
        return new static (
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getParameter()
        );
    }
}
