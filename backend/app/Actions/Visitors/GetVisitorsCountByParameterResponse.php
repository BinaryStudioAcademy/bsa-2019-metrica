<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use Illuminate\Support\Collection;

final class GetVisitorsCountByParameterResponse
{
    private $visitors;

    public function __construct(Collection $visitors)
    {
        $this->visitors = $visitors;
    }

    public function visitors(): Collection
    {
        return $this->visitors;
    }
}