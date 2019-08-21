<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Utils\DatePeriod;
use Illuminate\Support\Collection;

interface ChartVisitorRepository
{
    public function getTotalVisitorsByDateRange(
        DatePeriod $datePeriod,
        string $period,
        int $userId
    ): Collection;
}