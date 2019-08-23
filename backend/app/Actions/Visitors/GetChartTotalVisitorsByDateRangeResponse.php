<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use Illuminate\Support\Collection;

final class GetChartTotalVisitorsByDateRangeResponse
{
    private $totalVisitorsByDateRange;

    public function __construct(Collection $totalVisitorsByDateRange)
    {
        $this->totalVisitorsByDateRange = $totalVisitorsByDateRange;
    }

    public function getTotalVisitorsByDateRange(): Collection
    {
        return $this->totalVisitorsByDateRange;
    }
}