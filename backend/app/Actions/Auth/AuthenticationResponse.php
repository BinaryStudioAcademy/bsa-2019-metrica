<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use App\Contracts\ApiResponse as ApiResponseContract;

final class AuthenticationResponse implements ApiResponseContract
{
    private $token;

    public function __construct(
        string $token
    ) {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }
    public function toArray(): array
    {
        return [
            'token' => $this->getToken()
        ];
    }
}
