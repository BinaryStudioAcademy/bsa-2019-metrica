<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\GeoLocation\GetAllVisitorsCountAction;
use App\Actions\GeoLocation\GetAllVisitorsCountRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeoLocation\GeoLocationHttpRequest;
use App\Http\Resources\GeoLocationResource;
use App\Http\Resources\TableResource;
use App\Http\Response\ApiResponse;

final class GeoLocationController extends Controller
{
    private $getAllVisitorsCountAction;

    public function __construct(
        GetAllVisitorsCountAction $getAllVisitorsCountAction
    ) {
        $this->getAllVisitorsCountAction = $getAllVisitorsCountAction;
    }

    public function __invoke(GeoLocationHttpRequest $request): ApiResponse
    {
        $allVisitorsCount = $this->getAllVisitorsCountAction->execute(
            new GetAllVisitorsCountRequest(
               $request->startDate(),
               $request->endDate()
            )
        );

        $resource = collect([
            'all_visitors_count' => new TableResource($allVisitorsCount->allVisitorsCount())
        ]);

        return ApiResponse::success(new GeoLocationResource($resource));
    }
}
