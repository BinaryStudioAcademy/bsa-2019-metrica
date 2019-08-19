<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class TableVisitorsResourse extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'parameter_value' => $this->parameter_value,
            'visitors' => $this->count_visitors,
            'percentage' => $this->count_visitors/$this->total_count*100,
        ];
    }
}
