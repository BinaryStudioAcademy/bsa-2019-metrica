<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Contracts\ApiResponse;

class CountSessions extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'quantity_sessions' => $this->resource
        ];
    }
}
