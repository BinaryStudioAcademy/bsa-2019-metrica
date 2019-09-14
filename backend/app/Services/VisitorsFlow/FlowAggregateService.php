<?php
declare(strict_types=1);

namespace App\Services\VisitorsFlow;

use App\Entities\Visit;
use App\Repositories\Contracts\VisitRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

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
        if ($isFirstInSession) {
            return self::FIRST_LEVEL;
        }

        $level = $this->getVisits($visit)->count();

        return $level;
    }
    public function getVisits(Visit $visit): Collection
    {
        $visits = $this->visitRepository->findBySessionId($visit->session_id);
        $withoutDuplicates = $this->filterVisitDuplicates($visits);

        return $withoutDuplicates;
    }

    protected function getNextVisit(Visit $currentVisit): ?Visit
    {
        return $this->getVisits($currentVisit)
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
        return $this->getVisits($currentVisit)
            ->filter(function (Visit $visit) use ($currentVisit) {
                return $visit->id < $currentVisit->id;
            })
            ->sortBy(function (Visit $visit) {
                return $visit->id;
            })
            ->last();
    }

    protected function filterVisitDuplicates(Collection $visits): Collection
    {
        return $visits->reduce(function (Collection $result, Visit $visit) {
            $last = $result->last();

            if (!$last) {
                $result->push($visit);

                return $result;
            }

            if ($visit->page->url === $last->page->url) {
                $result->pop();
            }

            $result->push($visit);

            return $result;
        }, new Collection());
    }
}
