<?php

declare(strict_types=1);

namespace App\Actions\Auth;

final class RegisterResponse
{
    private $token;

    public function __construct()
    {
        $this->token = 'succeess';
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
