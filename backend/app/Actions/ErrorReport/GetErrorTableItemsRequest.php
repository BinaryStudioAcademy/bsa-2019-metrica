<?php

declare(strict_types=1);

namespace App\Actions\ErrorReport;

use App\Http\Requests\ErrorReport\GetErrorTableItemsHttpRequest;
use App\Actions\TableDataRequest;

class GetErrorTableItemsRequest extends TableDataRequest
{
    public static function fromRequest(GetErrorTableItemsHttpRequest $request)
    {
        return new static (
            $request->startDate(),
            $request->endDate(),
            $request->parameter()
        );
    }
}
