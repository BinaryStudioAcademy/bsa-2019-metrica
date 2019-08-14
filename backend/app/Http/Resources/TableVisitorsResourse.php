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
            $this->parameter_name => $this->parameter_value,
            'visitors' => $this->visitors_count,
            'percentage' => $this->visitors_count/$this->total_count*100,
        ];
    }
}
