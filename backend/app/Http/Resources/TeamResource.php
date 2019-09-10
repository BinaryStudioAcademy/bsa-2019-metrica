<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\Teams\TeamMember;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class TeamResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }
    public function present(TeamMember $item): array
    {
        return [
            'id' => $item->id(),
            'name' => $item->name(),
            'email' => $item->email(),
            'permitted_menu' => $item->menu()
        ];
    }
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(function ($item) {
            return $this->present($item);
        })->toArray();
    }
}