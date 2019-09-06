<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Http\Requests\Team\UpdatePermittedMenuItemsHttpRequest;
use Illuminate\Support\Collection;

final class UpdatePermittedMenuItemsRequest
{
    private $updateMenuList;
    private $websiteId;

    private function __construct(Collection $updateMenuList, int $websiteId)
    {
        $this->updateMenuList = $updateMenuList;
        $this->websiteId = $websiteId;
    }

    public static function fromRequest(UpdatePermittedMenuItemsHttpRequest $request): self
    {
        return new static(
            $request->updateList(),
            $request->websiteId()
        );
    }

    public function updateMenuList(): Collection
    {
        return $this->updateMenuList;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}
