<?php
declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Actions\ButtonDataRequest;
use App\Http\Requests\Api\GetPageViewsCountFilterHttpRequest;

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
