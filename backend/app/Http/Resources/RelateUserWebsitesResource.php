<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\Websites\WebsitesRelateToUser;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class RelateUserWebsitesResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }
    public function present(WebsitesRelateToUser $item): array
    {
        return [
            'id' => $item->id(),
            'name' => $item->name(),
            'domain' => $item->domain(),
            'single_page' => $item->singlePage(),
            'tracking_number' => $item->trackingNumber(),
            'role' => $item->userRole(),
            'permitted_menu' => $item->menuItems(),
        ];
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(function ($item) {
            return $this->present($item);
        })->toArray();
    }
}