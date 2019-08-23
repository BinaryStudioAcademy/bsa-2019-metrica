<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use Illuminate\Support\Collection;

final class GetNewChartVisitorsByDateRangeResponse
{
    private $visitorsByDateRange;

    public function __construct(Collection $visitorsByDateRange)
    {
        $this->visitorsByDateRange = $visitorsByDateRange;
    }

    public function getVisitorsByDateRange(): Collection
    {
        return $this->visitorsByDateRange;
    }
}
