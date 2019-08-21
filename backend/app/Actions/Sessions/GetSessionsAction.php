<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Contracts\Common\DatePeriod;
use App\DataTransformer\ChartValue;
use App\Exceptions\AppInvalidArgumentException;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\ChartSessionsRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\DataTransformer\Sessions\ChartSessionValue;

final class GetSessionsAction
{
    private $sessionsRepository;

    public function __construct(ChartSessionsRepository $sessionsRepository)
    {
        $this->sessionsRepository = $sessionsRepository;
    }

    public function execute(GetSessionsRequest $request): GetSessionsResponse
    {
        try {
            $websiteId = Auth::user()->website->id;
        } catch (\Exception $exception) {
            throw new WebsiteNotFoundException();
        }

        $interval = $this->getInterval($request->interval());

        if ($interval < 1) {
            throw new AppInvalidArgumentException('Interval must more 1 s');
        }

        $result = $this->getCountSessionsInPeriod($request->period(), $interval, $websiteId);

        return new GetSessionsResponse($result);
    }

    private function getCountSessionsInPeriod(DatePeriod $filterData, int $interval, int $websiteId): Collection
    {
        $startDate = $filterData->getStartDate()->getTimestamp();
        $endDate = $filterData->getEndDate()->getTimestamp();

        $arrayAllSessions = $this->sessionsRepository->findByFilter(
            $filterData,
            $websiteId
        );

        $result = [];

        for ($date = $startDate; $date < $endDate; $date += $interval) {
            $intervalEndDate = $date + $interval;

            $countSessions = $arrayAllSessions->filter(function (ChartSessionValue $chartSession) use ($date, $interval) {
                return (
                    $chartSession->getStartSession()->getTimestamp() <= ($date + $interval) &&
                    $chartSession->getEndSession()->getTimestamp() >= $date);
            })
                ->count();

            $result[] = new ChartValue((string) $intervalEndDate, (string) $countSessions);
        }

        return collect($result);
    }

    private function getInterval(string $interval): int
    {
        return (int) $interval;
    }
}