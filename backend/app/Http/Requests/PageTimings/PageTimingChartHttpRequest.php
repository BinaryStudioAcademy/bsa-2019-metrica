<?php


namespace App\Http\Requests\PageTimings;

use App\Http\Request\ApiFormRequest;
use App\Http\Requests\ChartHttpRequestTrait;

final class PageTimingChartHttpRequest  extends ApiFormRequest
{
    use ChartHttpRequestTrait;
}
