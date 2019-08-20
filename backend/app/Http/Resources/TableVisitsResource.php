<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class TableVisitsResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'parameter_value' => $this->parameter_value,
            'visits' => $this->count_visits,
            'percentage' => $this->count_visits/$this->total_count*100,
        ];
    }
}