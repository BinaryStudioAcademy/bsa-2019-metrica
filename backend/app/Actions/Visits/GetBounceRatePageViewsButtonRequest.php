<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Actions\ButtonDataRequest;
use App\Http\Requests\Visit\GetBouncePageViewsHttpRequest;

final class GetBounceRatePageViewsButtonRequest extends ButtonDataRequest
{
    public static function fromRequest(GetBouncePageViewsHttpRequest $request): self
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->websiteId()
        );
    }
}