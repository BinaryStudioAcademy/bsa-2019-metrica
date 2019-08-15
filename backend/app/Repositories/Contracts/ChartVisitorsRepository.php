<?php


namespace App\Repositories\Contracts;

use App\Actions\Visitors\GetNewChartVisitorsByDateRangeRequest;
use Illuminate\Support\Collection;

interface ChartVisitorsRepository
{
    public function getNewVisitorsByDate(GetNewChartVisitorsByDateRangeRequest $request): Collection;
}
