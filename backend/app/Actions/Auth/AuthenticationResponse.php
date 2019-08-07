<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

final class AuthenticationResponse
{
    private $accessToken;
    private $tokenType;

    public function __construct(
        string $accessToken,
        string $tokenType
    ) {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }
}
