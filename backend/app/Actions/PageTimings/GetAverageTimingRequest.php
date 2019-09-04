<?php

declare(strict_types=1);

namespace App\Actions\PageTimings;

use App\Actions\ButtonDataRequest;
use App\Http\Requests\System\FilterByPeriodHttpRequest;

class GetAverageTimingRequest extends ButtonDataRequest
{
    private $column;
    private $websiteId;

    public function __construct(FilterByPeriodHttpRequest $request, string $column, int $websiteId)
    {
        parent::__construct($request->getStartDate(), $request->getEndDate(), $request->websiteId());
        $this->column = $column;
        $this->websiteId = $websiteId;
    }

    public function column()
    {
        return $this->column;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}
