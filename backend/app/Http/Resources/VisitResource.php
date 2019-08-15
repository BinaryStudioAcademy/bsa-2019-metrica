<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class VisitResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'date' => '1565846640',
            'visits' => 1,
        ];
    }
}
