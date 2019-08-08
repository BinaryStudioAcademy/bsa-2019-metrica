<?php

declare(strict_types=1);

namespace App\Actions\Auth;

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