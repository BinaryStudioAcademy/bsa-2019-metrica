<?php

namespace App\Exceptions;

use App\Contracts\ApiException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ApiValidationException implements ApiException
{
    private $exception;

    public function __construct(ValidationException $exception)
    {
        $this->exception = $exception;
    }

    public function getStatus(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function toArray(): array
    {
        return [
            'error' => [
                'message' => $this->exception->validator->errors()->first()
            ]
        ];
    }
}