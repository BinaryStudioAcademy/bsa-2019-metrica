<?php

declare(strict_types=1);

namespace App\Actions\Auth;

final class ResetPasswordResponse
{
    private $code;

    public function __construct(int $code)
    {
        $this->code = $code;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
