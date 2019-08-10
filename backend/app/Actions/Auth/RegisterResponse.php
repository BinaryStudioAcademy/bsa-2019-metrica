<?php

declare(strict_types=1);

namespace app\Actions\Auth;

final class RegisterResponse
{
    private $token;

    public function __construct( string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}