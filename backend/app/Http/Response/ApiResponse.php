<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Contracts\ApiException as ApiExceptionContract;
use App\Contracts\ApiResponse as ApiResponseContract;
use Illuminate\Http\JsonResponse;

abstract class ApiResponse extends JsonResponse
{
    public static function success(ApiResponseContract $response): self
    {
        return new static($response->toArray());
    }

    public static function error(ApiExceptionContract $exception): self
    {
        return new static($exception->toArray(), $exception->getStatus());
    }
}