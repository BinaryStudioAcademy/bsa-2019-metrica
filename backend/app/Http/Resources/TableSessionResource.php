<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class TableSessionResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'parameter' => $request->get('filter')['parameter'],
            'parameter_value' => $this->parameter_value,
            'total' => $this->time_difference,
            'percentage' => $this->parameter_count
        ];
    }
}
