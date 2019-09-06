<?php

declare(strict_types=1);

namespace App\Actions\System;

use App\Http\Requests\System\FilterByPeriodHttpRequest;
use App\Utils\DatePeriod;

class GetMostPopularOsRequest
{
    private $period;
    private $websiteId;

    public function __construct(string $startDate, string $endDate, int $websiteId)
    {
        $this->period = DatePeriod::createFromTimestamp($startDate, $endDate);
        $this->websiteId = $websiteId;
    }

    public static function fromRequest(FilterByPeriodHttpRequest $request)
    {
        return new static (
            $request->getStartDate(),
            $request->getEndDate(),
            $request->websiteId()
        );
    }

    public function period(): DatePeriod
    {
        return $this->period;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}
