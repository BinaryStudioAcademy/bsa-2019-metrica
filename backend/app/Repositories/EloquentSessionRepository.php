<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\SessionRepository;
use Illuminate\Support\Collection;
use App\Actions\Sessions\CountSessionsFilter;
use App\Entities\Session;

class EloquentSessionRepository implements SessionRepository
{
    public function getCollection(): Collection
    {
        return collect([]);
    }

    public function countSessions(CountSessionsFilter $filter): int
    {
        return Session::whereIn('visitor_id', $filter->getVisitorsIDs())
                    ->where('start_session', '>=', $filter->getStartDate())
                    ->where('start_session', '<=', $filter->getEndDate())
                    ->count();
    }
}