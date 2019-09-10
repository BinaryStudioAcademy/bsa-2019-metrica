<?php

declare(strict_types=1);

namespace App\Actions\ErrorReport;

use Illuminate\Support\Collection;

final class GetChartErrorByDateRangeResponse
{
    private $errorsByDateRange;

    public function __construct(Collection $errorsByDateRange)
    {
        $this->errorsByDateRange = $errorsByDateRange;
    }

    public function getErrorCountByDateRange(): Collection
    {
        return $this->errorsByDateRange;
    }
}
