<?php

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ChartNewVisitorResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'date' => $this->date(),
            'value' => $this->value()
        ];
    }
}
