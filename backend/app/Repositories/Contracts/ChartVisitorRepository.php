<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface ChartVisitorRepository
{
    public function getTotalVisitorsByDateRange(
        string $startDate,
        string $endDate,
        string $period,
        int $userId
    ): Collection;
}