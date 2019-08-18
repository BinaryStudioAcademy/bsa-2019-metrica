<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class TableVisitorsResourseCollection extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'visitors' => $this->collection
        ];
    }
}