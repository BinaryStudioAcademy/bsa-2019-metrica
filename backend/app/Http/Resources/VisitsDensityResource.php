<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\Visits\VisitDensityItem;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class VisitsDensityResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function present(VisitDensityItem $item): array
    {
        return [
            'day' => $item->day(),
            'hour' => $item->hour(),
            'visits' => $item->visits(),
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection->map(function ($item) {
            return $this->present($item);
        })->toArray();
    }
}
