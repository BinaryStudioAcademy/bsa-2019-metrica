<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visitors\GetAllVisitorsAction;
use App\Actions\Visitors\GetNewVisitorsAction;
use App\Http\Resources\VisitorResource;
use App\Http\Response\ApiResponse;
use App\Http\Response\GetAllVisitorsResponse;
use App\Http\Controllers\Controller;
use App\Http\Response\GetNewVisitorsResponse;

final class VisitorController extends Controller
{
    private $getAllVisitorsAction;
    private $getNewVisitorsAction;

    public function __construct(
        GetAllVisitorsAction $getAllVisitorsAction,
        GetNewVisitorsAction $getNewVisitorsAction
    )
    {
        $this->getAllVisitorsAction = $getAllVisitorsAction;
        $this->getNewVisitorsAction = $getNewVisitorsAction;
    }

    public function getAllVisitors()
    {
        $response = $this->getAllVisitorsAction->execute();

        return ApiResponse::success(
            new GetAllVisitorsResponse([
                'visitors' => VisitorResource::collection($response->visitors())
            ])
        );
    }

    public function getNewVisitors()
    {
        $response = $this->getNewVisitorsAction->execute();

        return ApiResponse::success(
            new GetNewVisitorsResponse([
                'visitors' => VisitorResource::collection($response->visitors())
            ])
        );
    }
}
