<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\Actions\ButtonDataRequest;
use App\Http\Requests\Visit\GetUniquePageViewsHttpRequest;

class GetUniquePageViewsRequest extends ButtonDataRequest
{
    public static function fromRequest(GetUniquePageViewsHttpRequest $request): self
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate()
        );
    }
}
