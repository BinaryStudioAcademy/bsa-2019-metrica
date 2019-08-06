<?php

namespace App\Exceptions;

use App\Contracts\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ApiValidationException extends ValidationException implements ApiException
{
    private $validator;

    public function __construct(Validator $validator, ?Response $response = null, string $errorBag = 'default')
    {
        $this->validator = $validator;
        parent::__construct($validator, $response, $errorBag);
    }

    public function getStatus(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function toArray(): array
    {
        return [
            'error' => [
                'message' => $this->validator->errors()->first()
            ]
        ];
    }
}