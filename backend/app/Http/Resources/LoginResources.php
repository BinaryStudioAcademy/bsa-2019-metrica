<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            "data" => [
                'access_token' => $request->getAccessToken(),
                'token_type' => $request->getTokenType(),
                'expires_in' => $request->getExpiresIn()
            ],
            "meta" => []
        ];
    }
}
