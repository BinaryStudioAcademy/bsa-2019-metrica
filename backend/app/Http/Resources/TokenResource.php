<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class TokenResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'token' => $this->token()
        ];
    }
}
