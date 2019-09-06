<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use Illuminate\Support\Collection;

final class GetVisitsDensityResponse
{
    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function collection(): Collection
    {
        return $this->collection;
    }
}