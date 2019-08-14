<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class VisitorBounceRateResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'timestamp' => $this->getTimeStamp(),
            'rate' => $this->getRate(),
        ];
    }
}
