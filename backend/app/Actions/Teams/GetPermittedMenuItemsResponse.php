<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use Illuminate\Support\Collection;

final class GetPermittedMenuItemsResponse
{
    private $membersWithMenuItems;

    public function __construct(Collection $membersWithMenuItems)
    {
        $this->membersWithMenuItems = $membersWithMenuItems;
    }

    public function membersWithMenuItems(): Collection
    {
        return $this->membersWithMenuItems;
    }
}