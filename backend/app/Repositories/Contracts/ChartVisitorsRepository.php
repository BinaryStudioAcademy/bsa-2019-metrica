<?php


namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface ChartVisitorsRepository
{
    public function getNewVisitorsByDate(string $startData, string $endData, int $period, int $userId): Collection;
}
