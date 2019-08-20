<?php


namespace App\Repositories;

use App\Entities\Visitor;
use App\Repositories\Contracts\ButtonVisitorsRepository;
use App\Utils\DatePeriod;
use Carbon\Carbon;

class EloquentButtonVisitorsRepository implements ButtonVisitorsRepository
{
    public function getVisitorsCount(DatePeriod $period, int $websiteId, int $userId): int
    {
        $count = Visitor::where('website_id', $websiteId)->where(function ($query) use ($period) {
            $query->whereBetween('created_at', [
                (string)Carbon::instance($period->getStartDate()),
                (string)Carbon::instance($period->getEndDate())])
                ->orWhereBetween('last_activity', [
                        (string)Carbon::instance($period->getStartDate()),
                        (string)Carbon::instance($period->getEndDate())
                    ]
                );
        })->count();

        return $count;
    }
}
