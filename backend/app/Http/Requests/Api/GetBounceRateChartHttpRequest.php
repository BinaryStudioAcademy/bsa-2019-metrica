<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Request\ApiFormRequest;
use App\Http\Requests\ChartHttpRequestTrait;

final class GetBounceRateChartHttpRequest extends ApiFormRequest
{
    use ChartHttpRequestTrait;
}
