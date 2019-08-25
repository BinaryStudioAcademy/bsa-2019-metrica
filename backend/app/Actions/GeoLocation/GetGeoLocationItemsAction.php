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
        $countAllVisitors = $this->visitorRepository->countAllVisitorsGroupByCountry($request->period());

        $response = $countAllVisitors->map(function ($item) {
            return new GeoLocationItem($item->country, $item->all_visitors_count);
        });

        return new GetGeoLocationItemsResponse($response);
    }
}