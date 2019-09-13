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
            return  $this->visitRepository->findPreviousVisitsCount($visit->session_id,$visit->id);
        }
        return self::FIRST_LEVEL;
    }


    protected function getNextVisit(Visit $currentVisit): ?Visit
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)
            ->filter(function (Visit $visit) use ($currentVisit) {
                return $visit->id > $currentVisit->id;
            })
            ->sortBy(function (Visit $visit) {
                return $visit->id;
            })
            ->first();
    }


    protected function getPreviousVisit(Visit $currentVisit): ?Visit
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)
            ->filter(function (Visit $visit) use ($currentVisit) {
                return $visit->id < $currentVisit->id;
            })
            ->sortBy(function (Visit $visit) {
                return $visit->id;
            })
            ->last();
    }


}
