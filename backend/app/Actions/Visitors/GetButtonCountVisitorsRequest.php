<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Actions\ButtonDataRequest;
use App\Http\Requests\Visitor\GetButtonCountVisitorsHttpRequest;

final class GetButtonCountVisitorsRequest extends ButtonDataRequest
{
    public static function fromRequest(GetButtonCountVisitorsHttpRequest $request): self
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate()
        );
    }
}
