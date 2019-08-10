<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visitors\GetAllVisitorsAction;
use App\Http\Resources\VisitorResourceCollection;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;

final class VisitorController extends Controller
{
    private $getAllVisitorsAction;

    public function __construct(GetAllVisitorsAction $getAllVisitorsAction)
    {
        $this->getAllVisitorsAction = $getAllVisitorsAction;
    }

    public function getAllVisitors(): ApiResponse
    {
        $response = $this->getAllVisitorsAction->execute();

        return ApiResponse::success(new VisitorResourceCollection($response->visitors()));
    }
}
