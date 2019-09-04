<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\DataTransformer\Teams\MemberWithMenuItems;
use Illuminate\Support\Collection;

final class PermittedMenuResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }
    public function present(MemberWithMenuItems $item): array
    {
        return [
            'user_id' => $item->userId(),
            'website_id' => $item->websiteId(),
            'permitted_menu' => $item->menuItems()
        ];
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(function ($item) {
            return $this->present($item);
        })->toArray();
    }


}
