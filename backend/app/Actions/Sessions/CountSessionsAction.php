<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\DataTransformer\ButtonValue;
use App\Repositories\Contracts\SessionRepository;
use App\Repositories\Contracts\VisitorRepository;
use App\Actions\Sessions\CountSessionsRequest;
use App\Actions\Sessions\CountSessionsFilter;

final class CountSessionsAction
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

    public function execute(CountSessionsRequest $request): ButtonValue
    {
        $websiteId = auth()->user()->website->id;

        $visitorsIDsOfWebsite = $this->visitorRepository->getVisitorsOfWebsite((int) $websiteId)
                                                        ->pluck('id');

        $countSessionsFilter = new CountSessionsFilter($request, $visitorsIDsOfWebsite);

        $countSessions = $this->sessionRepository->countSessions($countSessionsFilter);

        return new ButtonValue((string)$countSessions);
    }
}
