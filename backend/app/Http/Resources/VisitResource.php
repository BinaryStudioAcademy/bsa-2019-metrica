<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class VisitResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'visit_time' => $this->visit_time,
            'ip_address' => $this->ip_address,
            'session' => new SessionResource($this->session),
            'page' => new PageResource($this->page),
            'geo_position' => new GeoPositionResource($this->geo_position)
        ];
    }
}
