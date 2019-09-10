<?php
declare(strict_types=1);

namespace App\Services\VisitorsFlow;

use App\Entities\Visit;
use App\Repositories\Contracts\VisitRepository;
use Carbon\Carbon;

abstract class FlowAggregateService
{
    protected const FIRST_LEVEL = 1;
    private $visitRepository;

    public function __construct(VisitRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    protected function getLevel(Visit $visit, bool $isFirstInSession): int
    {
        if (!$isFirstInSession) {
            return $this->getVisitsCount($visit);
        }
        return self::FIRST_LEVEL;
    }

    protected function getLastVisit(Visit $currentVisit): ?Visit
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)
            ->sortBy(function (Visit $visit) {
                return (new Carbon($visit->visit_time))->getTimestamp();
            })
            ->last(function (Visit $visit) use ($currentVisit) {
                return $currentVisit->id !== $visit->id;
            });
    }

    protected function getPreviousVisit(Visit $currentVisit): ?Visit
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)
            ->filter(function (Visit $visit) use ($currentVisit) {
                return (new Carbon($currentVisit->visit_time))->greaterThan(new Carbon($visit->visit_time));
            })
            ->sortBy(function (Visit $visit) {
                return (new Carbon($visit->visit_time))->getTimestamp();
            })
            ->last();
    }

    protected function getVisitsCount(Visit $currentVisit): int
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)->count();
    }
}
