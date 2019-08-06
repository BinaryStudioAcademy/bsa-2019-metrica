<?php

declare(strict_types=1);

namespace App\Action\Auth;

final class ResetPasswordResponse
{
    private $status;
    private $code;

    public function __construct(string $status,int $code)
    {
        $this->code = $code;
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
