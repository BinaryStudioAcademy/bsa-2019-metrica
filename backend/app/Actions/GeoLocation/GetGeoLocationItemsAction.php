<?php

declare(strict_types=1);

namespace App\Actions\GeoLocation;

use App\DataTransformer\GeoLocation\GeoLocationItem;
use App\Repositories\Contracts\SessionRepository;
use App\Repositories\Contracts\VisitorRepository;

final class GetGeoLocationItemsAction
{
    private $visitorRepository;
    private $sessionRepository;

    public function __construct(
        VisitorRepository $visitorRepository,
        SessionRepository $sessionRepository
    ) {
        $this->visitorRepository = $visitorRepository;
        $this->sessionRepository = $sessionRepository;
    }

    public function execute(GetGeoLocationItemsRequest $request): GetGeoLocationItemsResponse
    {
        $countAllVisitors = collect(
            $this->visitorRepository->countAllVisitorsGroupByCountry(
                    $request->startDate(),
                    $request->endDate()
                )
                ->keyBy('country')
                ->toArray()
        );

        $countNewVisitors = collect(
            $this->visitorRepository->countNewVisitorsGroupByCountry(
                    $request->startDate(),
                    $request->endDate()
                )
                ->keyBy('country')
                ->toArray()
        );

        $countAllSessions = collect(
            $this->sessionRepository->getCountSessionsGroupByCountry(
                $request->startDate(),
                $request->endDate()
            )
                ->keyBy('country')
                ->toArray()
        );

        $avgSessionTime = collect(
            $this->sessionRepository->getAvgSessionTimeGroupByCountry(
                $request->startDate(),
                $request->endDate()
            )
            ->keyBy('country')
            ->toArray()
        );

        $collection = $countAllVisitors->mergeRecursive($countNewVisitors)
            ->mergeRecursive($countAllSessions)
            ->mergeRecursive($avgSessionTime);

        $response = $collection->map(function ($item) {
            return new GeoLocationItem(
                $item['country'][0],
                $item['all_visitors_count'],
                $item['new_visitors_count'],
                $item['all_sessions_count'],
                0,
                (int) $item['avg_session_time']
            );
        })->flatten();

        return new GetGeoLocationItemsResponse($response);
    }
}

