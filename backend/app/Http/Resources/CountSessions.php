<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountSessions extends JsonResource
{
    public function toArray($request)
    {
        return [
            'qty_sessions' => $this->resource
        ];
    }
}
