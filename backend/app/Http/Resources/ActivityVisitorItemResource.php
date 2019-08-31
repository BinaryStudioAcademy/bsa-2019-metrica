<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\Visitors\ActiveVisitorItem;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class ActivityVisitorItemResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function present(ActiveVisitorItem $item): array
    {
        return [
            'url' => $item->url(),
            'visitor' => $item->visitor(),
            'date' => $item->date()
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection->map(function ($item) {
            return $this->present($item);
        })->toArray();
    }
}
