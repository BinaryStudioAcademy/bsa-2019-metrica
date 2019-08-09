<?php

declare(strict_types=1);

namespace App\Http\Response\Sessions;

use App\Contracts\ApiResponse;
use App\Http\Resources\SessionResource;
use Illuminate\Support\Collection;

final class GetAllSessionsResponse implements ApiResponse
{
    private $sessionCollection;

    public function __construct(Collection $sessionCollection)
    {
        $this->sessionCollection = $sessionCollection;
    }

    public function toArray(): array
    {
        return [
            'sessions' => SessionResource::collection($this->sessionCollection)
        ];
    }
}