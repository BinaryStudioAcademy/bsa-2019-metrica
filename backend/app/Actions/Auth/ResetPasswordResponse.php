<?php

declare(strict_types=1);

namespace App\Actions\Auth;

final class ResetPasswordResponse
{
    private $message = "Email notification sent";

    public function message(): string
    {
        return $this->message;
    }
}
