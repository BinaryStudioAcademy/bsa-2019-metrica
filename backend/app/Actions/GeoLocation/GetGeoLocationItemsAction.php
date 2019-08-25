<?php

declare(strict_types=1);

namespace App\Actions\GeoLocation;

use App\DataTransformer\GeoLocation\GeoLocationItem;
use App\Repositories\Contracts\VisitorRepository;

final class GetGeoLocationItemsAction
{
    private $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(GetGeoLocationItemsRequest $request): GetGeoLocationItemsResponse
    {
        $countAllVisitors = $this->visitorRepository
            ->countAllVisitorsGroupByCountry(
                $request->startDate(),
                $request->endDate()
            )
            ->keyBy('country')
            ->toBase();

        $countNewVisitors = $this->visitorRepository
            ->countNewVisitorsGroupByCountry(
                $request->startDate(),
                $request->endDate()
            )
            ->keyBy('country')
            ->toBase();

        $collection = $countAllVisitors->mergeRecursive($countNewVisitors);

        $response = $collection->map(function ($item) {
            return new GeoLocationItem(
                $item['country'][0],
                $item['all_visitors_count'],
                $item['new_visitors_count']
            );
        });

        return new GetGeoLocationItemsResponse($response);
    }
}