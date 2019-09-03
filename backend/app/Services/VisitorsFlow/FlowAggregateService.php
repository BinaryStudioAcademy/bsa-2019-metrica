<?php
declare(strict_types=1);

namespace App\Services\VisitorsFlow;

use App\Entities\Visit;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\VisitRepository;
use Carbon\Carbon;

final class FlowAggregateService
{
    private $pageRepository;
    private $visitRepository;

    public function __construct(
        PageRepository $pageRepository,
        VisitRepository $visitRepository
    )
    {
        $this->pageRepository = $pageRepository;
        $this->visitRepository = $visitRepository;
    }

    public function aggregate(Visit $visit)
    {
        $previousVisit = $this->getPreviousVisit($visit);
        $isFirstInSession = $previousVisit === null;
        if (!$isFirstInSession) {
            $level = $this->getVisitsCount($visit);
        } else {
            $level = 1;
        }
    }

    private function getPreviousVisit(Visit $currentVisit): ?Visit
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)
            ->sortBy(function (Visit $visit) {
                return (new Carbon($visit->visit_time))->getTimestamp();
            })
            ->last(function (Visit $visit) use ($currentVisit) {
                return $currentVisit->id !== $visit->id;
            });
    }

    private function getVisitsCount(Visit $currentVisit): int
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)->count();
    }
}
