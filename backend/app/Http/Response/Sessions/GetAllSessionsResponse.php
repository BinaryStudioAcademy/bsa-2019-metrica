<?php

declare(strict_types=1);

namespace App\Http\Response\Sessions;

use App\Contracts\ApiResponse;
use App\Http\Resources\SessionResource;

final class GetAllSessionsResponse implements ApiResponse
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = collect($data);
    }

    public function toArray(): array
    {
        return SessionResource::collection($this->data)->jsonSerialize();
    }
}