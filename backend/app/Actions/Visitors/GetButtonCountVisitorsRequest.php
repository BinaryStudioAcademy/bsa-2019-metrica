<?php

namespace App\Actions\Visitors;

use App\Actions\ButtonDataRequest;
use App\Http\Requests\Api\GetButtonCountVisitorsHttpRequest;

class GetButtonCountVisitorsRequest extends ButtonDataRequest
{
    public static function fromRequest(GetButtonCountVisitorsHttpRequest $request): self
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate()
        );
    }
}
