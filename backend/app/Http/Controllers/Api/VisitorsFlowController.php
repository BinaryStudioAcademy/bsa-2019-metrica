<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\VisitorsFlow\GetVisitorsFlowAction;
use App\Actions\VisitorsFlow\GetVisitorsFlowRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\VisitorsFlow\GetVisitorsFlowHttpRequest;
use App\Http\Resources\VisitorsFlowResource;
use App\Http\Response\ApiResponse;

final class VisitorsFlowController extends Controller
{
    private $getVisitorsFlowAction;

    public function __construct(GetVisitorsFlowAction $getVisitorsFlowAction)
    {
        $this->getVisitorsFlowAction = $getVisitorsFlowAction;
    }

    public function getVisitorsFlow(GetVisitorsFlowHttpRequest $request)
    {
        $result = $this->getVisitorsFlowAction->execute(GetVisitorsFlowRequest::fromRequest($request));
        return ApiResponse::success(new VisitorsFlowResource($result->getCollection()),['level'=>$request->getLevel()]);
    }
}
