<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class PermittedMenuResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'user_id' => $this->memberId(),
            'website_id' => $this->websiteId(),
            'permitted_menu' => $this->menu()->toArray()
        ];
    }
}
