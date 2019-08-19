<?php


namespace App\Repositories;

use App\Entities\Visitor;
use App\Repositories\Contracts\ButtonVisitorsRepository;

class EloquentButtonVisitorsRepository implements ButtonVisitorsRepository
{
    public function getVisitorsCount(string $startData, string $endData, int $websiteId, int $userId): int
    {
        $count = Visitor::where('website_id', $websiteId)->where(function ($query) use ($startData, $endData) {
            $query->whereBetween('created_at', [$startData, $endData])
                ->orWhereBetween('last_activity', [$startData, $endData]);
        })->count();

        return $count;
    }
}
