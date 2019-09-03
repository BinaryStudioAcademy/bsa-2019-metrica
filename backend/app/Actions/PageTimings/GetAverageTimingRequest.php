<?php

declare(strict_types=1);

namespace App\Actions\PageTimings;

use App\Actions\ButtonDataRequest;
use App\Http\Requests\System\FilterByPeriodHttpRequest;

class GetAverageTimingRequest extends ButtonDataRequest
{
    private $column;

    public function __construct(string $startDate, string $endDate, string $column)
    {
        parent::__construct($startDate, $endDate);
        $this->column = $column;
    }

    public static function fromRequest(FilterByPeriodHttpRequest $request, string $column)
    {
        return new static (
            $request->getStartDate(),
            $request->getEndDate(),
            $column
        );
    }

    public function column()
    {
        return $this->column;
    }
}
