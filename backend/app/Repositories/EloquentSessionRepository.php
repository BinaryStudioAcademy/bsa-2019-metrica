<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\SessionRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use App\Entities\Session;

class EloquentSessionRepository implements SessionRepository
{
    public function getCollection(): Collection
    {
        return collect([]);
    }

    public function getAvgSession(?int $days = null): int
    {
        $startDay = Carbon::today()->subDays($days);

        $avgSessionInSeconds = Session::when($days, function($query, $days){
                    return $query->where('start_session', '<=', $startDay);
                })
                ->get(['start_session', 'end_session'])
                ->map(function ($session) {
                    return $session->end_session->diffInSeconds($session->start_session);
                })
                ->avg();

        return round($avgSessionInSeconds);
    }
}