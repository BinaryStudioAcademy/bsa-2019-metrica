<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\SessionRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use App\Entities\Session;
use App\Actions\Sessions\GetAvgSessionRequest;
use App\Entities\Visitor;

class EloquentSessionRepository implements SessionRepository
{
    public function getCollection(): Collection
    {
        return collect([]);
    }

    public function getAvgSession(GetAvgSessionRequest $request): int
    {
        $websiteId = auth()->user()->website->id;

        $visitorsIDsOfWebsite = Visitor::where('website_id', $websiteId)
                                        ->get()
                                        ->pluck('id');

        $avgSession = Session::whereIn('visitor_id', $visitorsIDsOfWebsite)
                        ->where('start_session', '>=', Carbon::createFromTimestamp($request->startDate())->toDateString())
                        ->where('start_session', '<=', Carbon::createFromTimestamp($request->endDate())->toDateString())
                        ->get()
                        ->map(function ($session) {
                            return $session->end_session->diffInSeconds($session->start_session);
                        })
                        ->avg();

        return (int)round($avgSession);
    }
}