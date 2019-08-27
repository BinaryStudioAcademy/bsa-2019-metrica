<?php

declare(strict_types=1);

namespace App\Actions\ActiveUsers;

use Illuminate\Support\Collection;

final class GetActiveUserItemsResponse
{
    private $items;

    public function __construct(Collection $items)
    {
        $this->items = $items;
    }

    public function items(): Collection
    {
        return $this->items;
    }
}
