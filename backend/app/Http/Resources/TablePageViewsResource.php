<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\Visits\PageViewsItem;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class TablePageViewsResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }
    public function present(PageViewsItem $item): array
    {
        return [
            'page_url' => $item->pageUrl(),
            'page_title' => $item->title(),
            'count_page_views' => $item->pageViewsCount(),
            'bounce_rate' => $item->bounceRate(),
            'exit_rate' => $item->exitRate()
        ];
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(function ($item) {
            return $this->present($item);
        })->toArray();
    }
}