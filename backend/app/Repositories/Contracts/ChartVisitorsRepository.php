<?php


namespace App\Repositories\Contracts;


use App\Actions\Visitors\GetNewVisitorsByDateRangeRequest;

interface ChartVisitorsRepository
{
    public function getNewVisitorsByDate(GetNewVisitorsByDateRangeRequest $request);
}
