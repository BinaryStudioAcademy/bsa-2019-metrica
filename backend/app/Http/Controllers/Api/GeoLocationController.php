<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\GeoLocation\GetGeoLocationItemsAction;
use App\Actions\GeoLocation\GetGeoLocationItemsRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeoLocation\GeoLocationHttpRequest;
use App\Http\Resources\GeoLocationResource;
use App\Http\Resources\TableResource;
use App\Http\Response\ApiResponse;

final class GeoLocationController extends Controller
{
    private $getGeoLocationItemsAction;

    public function __construct(
        GetGeoLocationItemsAction $getGeoLocationItemsAction
    ) {
        $this->getGeoLocationItemsAction = $getGeoLocationItemsAction;
    }

    public function __invoke(GeoLocationHttpRequest $request): ApiResponse
    {
        $response = $this->getGeoLocationItemsAction->execute(
            new GetGeoLocationItemsRequest(
               $request->startDate(),
               $request->endDate()
            )
        )->items();

        return ApiResponse::success(new GeoLocationResource($response));
    }
}
