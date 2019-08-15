<?php

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ChartNewVisitorResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'period' => $this->period,
            'count' => $this->count
        ];
    }
}
