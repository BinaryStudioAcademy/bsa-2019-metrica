<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Contracts\ApiResponse;

final class RegistrationResponse implements ApiResponse
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}