<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class GeoLocationResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'all_visitors_count' => $this->collection->get('all_visitors_count'),
            // 'newest_visitors_count' => $this->collection->get('all_visitors_count')
            // 'session_count' => $this->collection->get('session_count')
            // 'bounce_rate' => $this->collection->get('bounce_rate')
            // 'average_session_time' => $this->collection->get('average_session_time')
        ];
    }
}
