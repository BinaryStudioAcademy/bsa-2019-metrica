<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class ButtonResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'value' => $this->value()
        ];
    }
}
