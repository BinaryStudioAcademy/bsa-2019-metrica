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
                    $request->endDate(),
                    $request->websiteId()
                )
                ->keyBy('country')
                ->toArray()
        );

        $countNewVisitors = collect(
            $this->visitorRepository->countNewVisitorsGroupByCountry(
                    $request->startDate(),
                    $request->endDate(),
                    $request->websiteId()
                )
                ->keyBy('country')
                ->toArray()
        );

        $countAllSessions = collect(
            $this->sessionRepository->getCountSessionsGroupByCountry(
                $request->startDate(),
                $request->endDate(),
                $request->websiteId()
            )
                ->keyBy('country')
                ->toArray()
        );

        $countBouncedVisitors = collect(
            $this->visitorRepository->countInactiveSingleVisitSessionGroupByCountry(
                $request->startDate(),
                $request->endDate(),
                $request->websiteId()
            )
                ->keyBy('country')
                ->toArray()
        );

        $avgSessionTime = collect(
            $this->sessionRepository->getAvgSessionTimeGroupByCountry(
                $request->startDate(),
                $request->endDate(),
                $request->websiteId()
            )
            ->keyBy('country')
            ->toArray()
        );

        $collection = $countAllVisitors->mergeRecursive($countNewVisitors)
            ->mergeRecursive($countAllSessions)
            ->mergeRecursive($countBouncedVisitors)
            ->mergeRecursive($avgSessionTime);

        $response = $collection->map(function ($item) {
            $bounce_rate = 0;

            if (isset($item['bounced_visitors_count']) && isset($item['all_visitors_count']) && $item['all_visitors_count'] > 0) {
                $bounce_rate = $item['bounced_visitors_count'] / $item['all_visitors_count'];
            }

            return new GeoLocationItem(
                $item['country'][0],
                $item['all_visitors_count'] ?? 0,
                $item['new_visitors_count'] ?? 0,
                $item['all_sessions_count'] ?? 0,
                $bounce_rate,
                (int) $item['avg_session_time'] ?? 0
            );
        })->flatten();

        return new GetGeoLocationItemsResponse($response);
    }
}

