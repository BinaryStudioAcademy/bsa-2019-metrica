<?php

declare(strict_types=1);

namespace App\Http\Requests\Visit;

use App\Http\Request\ApiFormRequest;
use App\Http\Requests\ChartHttpRequestTrait;

final class GetPageViewsChartAvgTimeHttpRequest extends ApiFormRequest
{
    use ChartHttpRequestTrait;
}
