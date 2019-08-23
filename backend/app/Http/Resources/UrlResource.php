<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class UrlResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'url' => $this->url()
        ];
    }
}
