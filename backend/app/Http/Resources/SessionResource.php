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
            'visitor_id' => $this->visitor_id,
            'start_session' => $this->start_session,
            'update_session' => $this->updated_at,
            'system' => new SystemResource($this->system),
            'entrance_page' => new PageResource($this->page),
            'language' => $this->language
        ];
    }
}
