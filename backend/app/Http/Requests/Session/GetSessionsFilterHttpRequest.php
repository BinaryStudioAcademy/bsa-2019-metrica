<?php

declare(strict_types=1);

namespace App\Http\Requests\Session;

use App\Http\Request\ApiFormRequest;
use App\Http\Requests\ChartHttpRequestTrait;

final class GetSessionsFilterHttpRequest extends ApiFormRequest
{
    use ChartHttpRequestTrait;
}
