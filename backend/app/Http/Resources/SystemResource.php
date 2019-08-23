<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class SystemResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'operating_system' => $this->os,
            'browser' => $this->browser,
            'device' => $this->device,
            'resolution_height' => $this->resolution_height,
            'resolution_width' => $this->resolution_width
        ];
    }
}
