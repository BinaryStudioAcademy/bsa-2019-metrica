<?php
declare(strict_types=1);

namespace App\Actions\Sessions;

use App\DataTransformer\ChartValue;
use App\Repositories\Contracts\ChartSessionRepository;
use App\Repositories\Contracts\VisitorRepository;
use App\Utils\DatePeriod;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class GetAverageSessionByIntervalAction
{
    private $repository;
    private $visitorRepository;

    public function __construct(
        ChartSessionRepository $repository,
        VisitorRepository $visitorRepository
    ) {
        $this->repository = $repository;
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(GetAverageSessionByIntervalRequest $request): GetAverageSessionByIntervalResponse
    {
        $filterData = $request->getFilterData();
        $from = $filterData->getStartDate();
        $to = $filterData->getEndDate();
        $timeFrame = $filterData->getTimeFrame();
        //$websiteId = auth()->user()->website->id;
        $visitorsIDsOfWebsite = $this->visitorRepository->getVisitorsOfWebsite((int) 1)
            ->pluck('id');
        $start = $from->getTimestamp();
        $end = $to->getTimestamp();
        $responseCollection = new Collection();

        do {
            $intervalEnd = $start + $timeFrame;
            $datePeriod = DatePeriod::createFromTimestamp($start, $intervalEnd);
            $currentIntervalSessions = $this->repository->getSessionByInterval($datePeriod, $visitorsIDsOfWebsite);
            $currentIntervalSessionsCount = $currentIntervalSessions->count();

            if ($currentIntervalSessionsCount !== 0) {
                $currentIntervalSessionsTime = $currentIntervalSessions->reduce(
                    function ($carry, $session) use ($start, $intervalEnd) {
                        $sessionStart = Carbon::createFromFormat('Y-m-d H:i:s', $session->start_session)
                            ->getTimestamp();
                        $sessionEnd = Carbon::createFromFormat('Y-m-d H:i:s', $session->end_session)
                            ->getTimestamp();
                        if ($sessionStart < $start && $sessionEnd >= $start && $sessionEnd <= $intervalEnd) {
                            $carry += $sessionEnd - $start;
                        } elseif ($sessionStart >= $start && $sessionEnd <= $intervalEnd) {
                            $carry += $sessionEnd - $sessionStart;
                        } elseif ($sessionStart >= $start && $sessionEnd > $intervalEnd) {
                            $carry += $intervalEnd - $sessionStart;
                        } elseif ($sessionStart <= $start && $sessionEnd >= $intervalEnd) {
                            $carry += $intervalEnd - $start;
                        }

                        return $carry;
                    }, 0
                );
                $avgSessionTime = $currentIntervalSessionsTime / $currentIntervalSessionsCount;
                if ($avgSessionTime !== 0) {
                    $responseCollection->add(new ChartValue(
                            Carbon::createFromTimestampUTC($intervalEnd)->toDateString(),
                            (string)$avgSessionTime)
                    );
                }
            }
        } while (($start += $timeFrame) <= $end);

        return new GetAverageSessionByIntervalResponse($responseCollection);
    }
}
