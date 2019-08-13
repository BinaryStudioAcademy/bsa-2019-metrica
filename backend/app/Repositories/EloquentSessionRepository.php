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

        // it will be actual when User->Website relations is changed to OneToOne
        $websiteId = auth()->user()->website->id;

        $visitorsIDsOfWebsite = Visitor::where('website_id', $websiteId)
                                        ->get(['id']);

        $avgSession = Session::whereIn('visitor_id', $visitorsIDsOfWebsite)
                        ->where('start_session', '>=', $request->startDate())
                        ->where('start_session', '<=', $request->endDate())
                        ->get(['start_session', 'end_session'])
                        ->map(function ($session) {
                            return $session->end_session->diffInSeconds($session->start_session);
                        })
                        ->avg();

        return round($avgSession);
    }
}