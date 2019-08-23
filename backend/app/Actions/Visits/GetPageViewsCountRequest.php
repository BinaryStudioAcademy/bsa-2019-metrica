<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\Actions\ButtonDataRequest;
use App\Http\Requests\Visit\GetPageViewsCountFilterHttpRequest;

final class GetPageViewsCountRequest extends ButtonDataRequest
{
    public static function fromRequest(GetPageViewsCountFilterHttpRequest $request)
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate()
        );
    }
}
