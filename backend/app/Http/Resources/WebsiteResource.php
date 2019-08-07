<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class WebsiteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'domain' => $this->domain,
                'single_page' => $this->single_page,
                'user_id' => $this->user_id,
                'tracking_info_id' => $this->tracking_info_id
            ],
            'meta' => [],
        ];
    }
}
