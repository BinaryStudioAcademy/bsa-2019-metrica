<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use Illuminate\Support\Collection;

final class UpdatePermittedMenuItemsResponse
{
    private $updatedMenuList;

    public function __construct(Collection $updatedMenuList)
    {
        $this->updatedMenuList = $updatedMenuList;
    }

    public function updatedMenuList(): Collection
    {
        return $this->updatedMenuList;
    }
}