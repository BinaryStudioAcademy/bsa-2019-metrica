<?php

declare(strict_types=1);

namespace App\Actions\Auth;

final class SocialAuthRequest
{
    private $provider;

    public function __construct(string $provider)
    {
        $this->provider = $provider;
    }

    public function provider(): string
    {
        return $this->provider;
    }
}
