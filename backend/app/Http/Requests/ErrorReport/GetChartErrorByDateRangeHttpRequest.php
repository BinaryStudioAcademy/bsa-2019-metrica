<?php

declare(strict_types=1);

namespace App\Http\Requests\ErrorReport;

use App\Http\Request\ApiFormRequest;
use App\Http\Requests\ChartHttpRequestTrait;

final class GetChartErrorByDateRangeHttpRequest extends ApiFormRequest
{
    use ChartHttpRequestTrait;
}
