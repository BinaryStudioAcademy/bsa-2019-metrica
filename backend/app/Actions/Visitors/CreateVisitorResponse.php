<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

final class CreateVisitorResponse
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