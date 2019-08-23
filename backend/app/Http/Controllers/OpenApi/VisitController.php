<?php

declare(strict_types=1);

namespace App\Http\Controllers\OpenApi;

use App\Actions\Visits\CreateVisitAction;
use App\Actions\Visits\CreateVisitRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Visit\CreateVisitHttpRequest;
use App\Http\Response\ApiResponse;

final class VisitController extends Controller
{
    private $createVisitAction;

    public function __construct(CreateVisitAction $createVisitAction)
    {
        $this->createVisitAction = $createVisitAction;
    }

    public function createVisit(CreateVisitHttpRequest $request): ApiResponse
    {
        $this->createVisitAction->execute(CreateVisitRequest::fromRequest($request));

        return ApiResponse::emptySuccess();
    }
}
