<?php

declare(strict_types=1);

namespace App\Actions\Auth;

final class RegisterResponse
{
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function token(): string
    {
        return $this->token;
    }
}