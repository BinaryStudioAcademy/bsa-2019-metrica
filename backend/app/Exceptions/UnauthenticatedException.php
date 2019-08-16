<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\ApiException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;

final class UnauthenticatedException extends AuthenticationException implements ApiException
{
    protected $message = "Something wrong with email or password";

    public function __construct(string $message = '', array $guards = [], ?string $redirectTo = null)
    {
        parent::__construct($this->message, $guards, $redirectTo);
    }

    public function getStatus(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message
        ];
    }
}
