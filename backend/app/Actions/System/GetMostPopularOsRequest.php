<?php

declare(strict_types=1);

namespace App\Actions\System;

use App\Http\Requests\System\FilterByPeriodHttpRequest;
use App\Utils\DatePeriod;

class GetMostPopularOsRequest
{
    private $period;

    public function __construct(string $startDate, string $endDate)
    {
        $this->period = DatePeriod::createFromTimestamp($startDate, $endDate);
    }

    public static function fromRequest(FilterByPeriodHttpRequest $request)
    {
        return new static (
            $request->getStartDate(),
            $request->getEndDate()
        );
    }

    public function period(): DatePeriod
    {
        return $this->period;
    }
}
