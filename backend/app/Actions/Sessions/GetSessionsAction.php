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


//        $startDate = $request->period()->getStartDate()->getTimestamp(); //1566194400  2019-08-19 06:00:00
//        $endDate = $request->period()->getEndDate()->getTimestamp();    //1566201600  2019-08-19 08:00:00



        $result = $this->getCountSessionsInPeriod($request->period(), $interval, $websiteId);

//        dd($request);

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

            $array[] = [
                "date" => $intervalEndDate,
                "sessions" => $countSessions,
            ];

            };


            dd($array);

//            count($sessions, $session->start_session <= $date + $interval && $session->end_session >= $date);

//        return collect($result)->map(function ($item) {
//            return array(
//                $item->date,
//                $item->sessions,
//            );
//        });
    }

    private function getInterval(string $interval): int
    {
        return (int) $interval;
    }
}