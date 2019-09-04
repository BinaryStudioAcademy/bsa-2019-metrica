<?php

declare(strict_types=1);

namespace App\Actions\PageTimings;

use App\Actions\TableDataRequest;
use App\Http\Request\PageTimingTableHttpRequest;

class GetAverageTimingByParamRequest extends TableDataRequest
{
    private $column;

    public function __construct(PageTimingTableHttpRequest $request, string $column)
    {
        parent::__construct($request->getStartDate(), $request->getEndDate(), $request->getParameter());
        $this->column = $column;
    }

    public function column()
    {
        return $this->column;
    }
}
