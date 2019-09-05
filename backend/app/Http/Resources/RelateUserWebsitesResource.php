<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\WebsiteValue;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class RelateUserWebsitesResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }
    public function present(WebsiteValue $item): array
    {
        return [
            'id' => $item->id(),
            'domain' => $item->domain(),
            'role' => $item->role(),
        ];
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(function ($item) {
            return $this->present($item);
        })->toArray();
    }
}