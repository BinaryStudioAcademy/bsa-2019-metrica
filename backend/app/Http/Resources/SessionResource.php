<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class SessionResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'start_session' => $this->start_session,
            'visitor_id' => $this->visitor_id,
            'entrance_page_id' => $this->entrance_page_id,
            'demographic_id' => $this->demographic_id,
            'device_id' => $this->device_id,
            'system_id' => $this->system_id,
            'website_id' => $this->website_id,
        ];
    }
}
