<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Tymon\JWTAuth\Facades\JWTAuth;


final class VisitorResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource,
            'token' => $this->getJWTToken()
        ];
    }

    private function getJWTToken(): string
    {
        return JWTAuth::fromUser(auth()->user());
    }
}
