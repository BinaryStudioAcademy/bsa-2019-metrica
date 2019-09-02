<?php

declare(strict_types=1);

namespace App\Http\Requests\Visitor;

use App\Http\Request\ApiFormRequest;
use App\Http\Requests\ChartHttpRequestTrait;

final class GetVisitorsBounceRateHttpRequest extends ApiFormRequest
{
    use ChartHttpRequestTrait;
}
