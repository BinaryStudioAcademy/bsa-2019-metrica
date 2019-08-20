<?php
declare(strict_types=1);

namespace App\Actions\Visitors;

use Illuminate\Support\Collection;

final class BounceRateResponse
{
    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function getVisitorsBounceRateCollection(): Collection
    {
        return $this->collection;
    }
}
