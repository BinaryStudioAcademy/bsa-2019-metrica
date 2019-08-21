<?php

declare(strict_types=1);

namespace App\Actions\Auth;

final class SocialAuthenticationResponse
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
