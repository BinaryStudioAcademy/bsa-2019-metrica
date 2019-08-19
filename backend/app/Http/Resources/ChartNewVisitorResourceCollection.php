<?php

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChartNewVisitorResourceCollection extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->collection->toArray();
    }
}
