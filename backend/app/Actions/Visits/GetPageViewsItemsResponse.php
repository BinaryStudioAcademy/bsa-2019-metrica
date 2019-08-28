<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use Illuminate\Support\Collection;

final class GetPageViewsItemsResponse
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