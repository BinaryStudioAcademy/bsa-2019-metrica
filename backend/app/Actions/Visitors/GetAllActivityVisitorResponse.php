<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use Illuminate\Support\Collection;

final class GetAllActivityVisitorResponse
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
