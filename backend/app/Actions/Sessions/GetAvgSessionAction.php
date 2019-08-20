<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Repositories\Contracts\SessionRepository;
use App\Repositories\Contracts\VisitorRepository;
use App\Actions\Sessions\GetAvgSessionRequest;
use App\Actions\Sessions\AverageSessionFilter;

final class GetAvgSessionAction
{
    private $sessionRepository;
    private $visitorRepository;

    public function __construct(
        SessionRepository $sessionRepository,
        VisitorRepository $visitorRepository
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(GetAvgSessionRequest $request): GetAvgSessionResponse
    {
        $websiteId = auth()->user()->website->id;

        $visitorsIDsOfWebsite = $this->visitorRepository->getVisitorsOfWebsite((int) $websiteId)
                                                        ->pluck('id');

        $avgSessionFilter = new AverageSessionFilter($request, $visitorsIDsOfWebsite);

        $avgSessionInSeconds = (int)$this->sessionRepository->getAvgSession($avgSessionFilter)
                                                       ->first()
                                                       ->avg;

        return new GetAvgSessionResponse($avgSessionInSeconds);
    }
}