<?php

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'email' => $this->getEmail()
        ];
    }
}
