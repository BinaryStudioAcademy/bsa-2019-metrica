<?php

declare(strict_types=1);

namespace App\Actions\Auth;

final class SocialRedirectResponse
{
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function url():string
    {
        return $this->url;
    }
}
