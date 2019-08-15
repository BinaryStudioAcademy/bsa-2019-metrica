<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Repositories\Contracts\SessionRepository;
use App\Actions\Sessions\GetAvgSessionRequest;
use App\Repositories\Contracts\VisitorRepository;

final class GetAvgSessionAction
{
    private $sessionRepository;

    public function __construct(
        SessionRepository $sessionRepository,
        VisitorRepository $visitorRepository
    )
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function execute(GetAvgSessionRequest $request): GetAvgSessionResponse
    {
        $websiteId = auth()->user()->website->id;

        $visitorsIDsOfWebsite = $this->visitorRepository->getVisitorsOfWebsite((int) $websiteId)
                                                        ->pluck('id');

        $avgSessionInSeconds = $this->sessionRepository->getAvgSession($request, $visitorsIDsOfWebsite);

        return new GetAvgSessionResponse($avgSessionInSeconds);
    }
}