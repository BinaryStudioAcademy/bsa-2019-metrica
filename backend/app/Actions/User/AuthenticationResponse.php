<?php

declare(strict_types=1);

namespace app\Actions\User;

final class AuthenticationResponse
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