<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use Illuminate\Support\Collection;

final class GetPermittedMenuItemsResponse
{
    private $menu;
    private $websiteId;
    private $memberId;

    public function __construct(Collection $menu, int $websiteId, int $memberId)
    {
        $this->menu = $menu;
        $this->websiteId = $websiteId;
        $this->memberId = $memberId;
    }

    public function menu(): Collection
    {
        return $this->menu;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }

    public function memberId(): int
    {
        return $this->memberId;
    }
}