<?php

declare(strict_types=1);

namespace App\Actions\PageTimings;

use App\Actions\ButtonDataRequest;
use App\Http\Requests\System\FilterByPeriodHttpRequest;

class GetAverageTimingRequest extends ButtonDataRequest
{
    private $column;

    public function __construct(FilterByPeriodHttpRequest $request, string $column)
    {
        parent::__construct($request->getStartDate(), $request->getEndDate(), $request->websiteId());
        $this->column = $column;
    }

    public function column()
    {
        return $this->column;
    }
}
