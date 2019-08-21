<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Contracts\Common\DatePeriod;
use App\DataTransformer\Sessions\ChartSessions;
use App\Exceptions\AppInvalidArgumentException;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\ChartSessionsRepository;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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

        $interval = $this->getInterval($request->interval()); //3600
        if ($interval < 1) {
            throw new AppInvalidArgumentException('Interval must more 1 s');
        }

        $result = $this->getCountSessionsInPeriod($request->period(), $interval, $websiteId);

//        dd($result);

        return new GetSessionsResponse($result);
    }

    private function getCountSessionsInPeriod(DatePeriod $filterData, int $interval, int $websiteId): Collection
    {
        $startTimestamp = $filterData->getStartDate()->getTimestamp();
        $endTimestamp = $filterData->getEndDate()->getTimestamp();
        $startDate = $startTimestamp - ($startTimestamp % $interval);
        $endDate = $endTimestamp - ($endTimestamp % $interval);

        for ($date = $startDate; $date < $endDate; $date += $interval) {
            $intervalEndDate = $date + $interval;
            $period = \App\Utils\DatePeriod::createFromTimestamp($date, $intervalEndDate);

            $arraySessions = $this->sessionsRepository->findByFilter(
                $period,
                $websiteId
            );

            $countSessions = count($arraySessions);

//            $result[] = (object )[
//                'date' => $intervalEndDate,
//                'sessions' => $countSessions,
//            ];

            $result[] = new ChartSessions((string) $intervalEndDate, $countSessions);
        }

        return collect($result);

//        return collect($result)->map(function ($item) {
//            return new ChartSessions($item->date, $item->sessions);
//        });
    }

    private function getInterval(string $interval): int
    {
        return (int) $interval;
    }
}