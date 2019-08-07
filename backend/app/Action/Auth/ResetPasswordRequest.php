<?php

declare(strict_types=1);

namespace App\Action\Auth;

final class ResetPasswordRequest
{
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}