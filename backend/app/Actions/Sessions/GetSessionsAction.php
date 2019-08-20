<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\DataTransformer\Sessions\ChartSessions;
use App\Exceptions\AppInvalidArgumentException;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\ChartSessionsRepository;
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

        if ($interval < 1) {
            throw new AppInvalidArgumentException('Interval must more 500 ms');
        }

        $data = $this->sessionsRepository->findByFilter(
            $request->period(),
            $interval,
            $websiteId
        );

//        dd($data);

        foreach ($data as $key => $value) {
            $session = $data[$key][1];
            dd($session);


//            return collect($result)->map(function ($item) {
//                return new ChartSessions($item->date, $item->sessions);
        }


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


        return new GetSessionsResponse($data);
    }

    private function getInterval(string $interval): int
    {
        return (int) $interval;
    }
}