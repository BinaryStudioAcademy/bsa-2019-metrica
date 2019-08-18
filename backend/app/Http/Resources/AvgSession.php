<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Contracts\ApiResponse;
use Illuminate\Support\Carbon;

class AvgSession extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'avg_session' => $this->resource
        ];
    }
}
