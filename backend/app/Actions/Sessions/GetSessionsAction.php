<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\DataTransformer\Sessions\ChartSessions;
use App\Exceptions\AppInvalidArgumentException;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\ChartSessionsRepository;
use DateTime;
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

        $interval = $this->getInterval($request->interval());
        $startDate = $request->period()->getStartDate(); //@1566198000  2019-08-19 07:00:00
        $endDate = $request->period()->getEndDate(); //@1566201600  2019-08-19 08:00:00

        if ($interval < 1) {
            throw new AppInvalidArgumentException('Interval must more 1 s');
        }

        $arraySessions = $this->sessionsRepository->findByFilter(
            $request->period(),
            $interval,
            $websiteId
        );

        dd($startDate);

        for ($date = $startDate; $date < $endDate; $date += $interval) {
//            count($sessions, $session->start_session <= $date + $interval && $session->end_session >= $date);
        }


//        foreach ($arraySessions as $key => $value) {
//            $session = $dataArray[$key][1];
//            dd($session);


//            return collect($result)->map(function ($item) {
//                return new ChartSessions($item->date, $item->sessions);
//        }

//        for ($date = $startDate; $date < $endDate; $date += $interval)
//            count($sessions, $session->start_session <= $date + $interval && $session->end_session >= $date)


//
//        $result = Session::where('website_id', $websiteId)
//            ->whereDateBetween($filterData)
//            ->get()
//            ->reduce(function ($hashTable, $item) use ($interval) {
//                $startTimestamp = $item->start_session->getTimestamp();
//                $endTimestamp = $item->end_session->getTimestamp();
//                $startDate = $startTimestamp - ($startTimestamp % $interval) + $interval;
//                dd($startDate);
//                $endDate = $endTimestamp - ($endTimestamp % $interval) + $interval;
//
//                for ($offset = $endDate - $startDate; $offset > 0; $offset -= $interval) {
//                    $position = $startDate + $offset;
//
//                    if (!isset($hashTable[$position]) || is_null($hashTable[$position])) {
//                        $hashTable[$position] = 0;
//                    }
//
//                    $hashTable[$position]++;
//                }
//
//                return $hashTable;
//            }, []);
//
//        return collect($result);


        return new GetSessionsResponse($result);
    }

    private function getInterval(string $interval): int
    {
        return (int) $interval;
    }
}