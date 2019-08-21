<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\ApiException;
use Exception;
use Illuminate\Http\Response;

class EndpointNotFoundException extends Exception implements ApiException
{
    public function getStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    public function toArray(): array
    {
        return [
            'message' => 'Endpoint not found.'
        ];
    }
}
