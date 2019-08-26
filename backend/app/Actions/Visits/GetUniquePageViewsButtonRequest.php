<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\Actions\ButtonDataRequest;
use App\Http\Requests\Visit\GetUniquePageViewsButtonHttpRequest;

class GetUniquePageViewsButtonRequest extends ButtonDataRequest
{
    public static function fromRequest(GetUniquePageViewsButtonHttpRequest $request): self
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate()
        );
    }
}
