<?php
declare(strict_types=1);

namespace App\Actions\Sessions;

use App\DataTransformer\ChartValue;
use App\DataTransformer\Sessions\ChartSessionValue;
use App\Exceptions\AppInvalidArgumentException;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\ChartSessionsRepository;
use App\Repositories\Contracts\VisitorRepository;
use App\Utils\DatePeriod;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

final class GetAverageSessionByIntervalAction
{
    private $repository;
    private $visitorRepository;

    public function __construct(
        ChartSessionsRepository $repository,
        VisitorRepository $visitorRepository
    ) {
        $this->repository = $repository;
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(GetSessionsRequest $request): GetAverageSessionByIntervalResponse
    {
        try {
            $websiteId = Auth::user()->website->id;
        } catch (\Exception $exception) {
            throw new WebsiteNotFoundException();
        }

        $interval = $this->getInterval($request->interval());

        if ($interval < 1) {
            throw new AppInvalidArgumentException('Interval should be greater than 1 second');
        }

        $result = $this->getAvgSessionsTimeInPeriod($request->period(), $interval, $websiteId);

        return new GetAverageSessionByIntervalResponse($result);
    }

    private function getAvgSessionsTimeInPeriod(DatePeriod $filterData, int $interval, int $websiteId): Collection
    {
        $startDate = $filterData->getStartDate()->getTimestamp();
        $endDate = $filterData->getEndDate()->getTimestamp();

        $arrayAllSessions = $this->repository->findByFilter(
            $filterData,
            $websiteId
        );

        $result = [];

        for ($date = $startDate; $date < $endDate; $date += $interval) {
            $intervalEndDate = $date + $interval;

            $currentIntervalSessions = $arrayAllSessions->filter(
                function (ChartSessionValue $chartSession) use ($date, $intervalEndDate) {
                    return (
                        $chartSession->getStartSession()->getTimestamp() < $intervalEndDate &&
                        $chartSession->getEndSession()->getTimestamp() > $date);
                }
            );

            if ($currentIntervalSessions->count() === 0) {
                $result[] = new ChartValue(
                    Carbon::createFromTimestampUTC($intervalEndDate)->toDateString(),
                    '0'
                );
                continue;
            }

            $currentIntervalSessionsTime = $currentIntervalSessions->reduce(
                function ($carry, ChartSessionValue $session) use ($date, $intervalEndDate) {
                    return $this->calculateSessionTimeByInterval($session, $carry, $date, $intervalEndDate);
                }, 0);
            $avgSessionTime = $currentIntervalSessionsTime / $currentIntervalSessions->count();

            $result[] = new ChartValue(
                (string)$intervalEndDate,
                (string) $avgSessionTime
            );
        }

        return collect($result);
    }

    private function getInterval(string $interval): int
    {
        return (int) $interval;
    }

    private function calculateSessionTimeByInterval(
        ChartSessionValue $session,
        int $carry,
        int $date,
        int $intervalEndDate
    ) {
        $sessionStart = $session->getStartSession()->getTimestamp();
        $sessionEnd = $session->getEndSession()->getTimestamp();
        if ($this->isSessionEndInInterval($sessionStart, $sessionEnd, $date, $intervalEndDate)) {
            $carry += $sessionEnd - $date;
        } elseif ($this->isSessionInInterval($sessionStart, $sessionEnd, $date, $intervalEndDate)) {
            $carry += $sessionEnd - $sessionStart;
        } elseif ($this->isSessionStartInInterval($sessionStart, $sessionEnd, $date, $intervalEndDate)) {
            $carry += $intervalEndDate - $sessionStart;
        } elseif ($this->isSessionActiveDuringInterval($sessionStart, $sessionEnd, $date, $intervalEndDate)) {
            $carry += $intervalEndDate - $date;
        }

        return $carry;
    }

    private function isSessionEndInInterval(int $sessionStart, int $sessionEnd, int $date, int $intervalEndDate)
    {
        return $sessionStart < $date && $sessionEnd >= $date && $sessionEnd <= $intervalEndDate;
    }

    private function isSessionInInterval(int $sessionStart, int $sessionEnd, int $date, int $intervalEndDate)
    {
        return $sessionStart >= $date && $sessionEnd <= $intervalEndDate;
    }

    private function isSessionStartInInterval(int $sessionStart, int $sessionEnd, int $date, int $intervalEndDate)
    {
        return $sessionStart >= $date && $sessionEnd > $intervalEndDate;
    }

    private function isSessionActiveDuringInterval(int $sessionStart, int $sessionEnd, int $date, int $intervalEndDate)
    {
        return $sessionStart <= $date && $sessionEnd >= $intervalEndDate;
    }
}
