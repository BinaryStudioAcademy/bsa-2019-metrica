<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\GeoLocation\GeoLocationItem;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class GeoLocationResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function present(GeoLocationItem $item): array
    {
        return [
            'country' => $item->country(),
            'all_visitors_count' => $item->allVisitorsCount(),
            'new_visitors_count' => $item->newVisitorsCount(),
            'sessions_count' => $item->sessionsCount(),
            'bounce_rate' => $item->bounceRate(),
            'avg_session_time' => $item->avgSessionTime()
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection->map(function ($item) {
            return $this->present($item);
        })->toArray();
    }
}
