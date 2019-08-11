<?php

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteResource extends JsonResource implements ApiResponse
{

    public function toArray($request):  array
    {
        return [
            'name' => $this->name,
            'domain' => $this->domain,
            'single_page' => $this->single_page,
            'tracking_number' => $this->tracking_number
        ];
    }
}
