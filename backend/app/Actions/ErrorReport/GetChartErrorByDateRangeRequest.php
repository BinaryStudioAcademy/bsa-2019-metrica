<?php

declare(strict_types=1);

namespace App\Actions\ErrorReport;

use App\Actions\ChartDataRequest;
use App\Http\Requests\ErrorReport\GetChartErrorByDateRangeHttpRequest;

final class GetChartErrorByDateRangeRequest extends ChartDataRequest
{
    public static function fromRequest(GetChartErrorByDateRangeHttpRequest $request): self
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getPeriod()
        );
    }
}
