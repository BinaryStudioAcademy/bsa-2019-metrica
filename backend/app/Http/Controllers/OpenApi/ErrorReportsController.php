<?php

declare(strict_types=1);

namespace App\Http\Controllers\OpenApi;

use App\Actions\ErrorReports\AddErrorReportsAction;
use App\Actions\Visits\CreateVisitRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ErrorReports\AddErrorReportsHttpRequest;
use App\Http\Requests\Visit\CreateVisitHttpRequest;
use App\Http\Response\ApiResponse;

final class ErrorReportsController extends Controller
{
    private $addErrorReportsAction;

    public function __construct(AddErrorReportsAction $addErrorReportsAction)
    {
        $this->addErrorReportsAction = $addErrorReportsAction;
    }

    public function addErrorReports(AddErrorReportsHttpRequest $request): ApiResponse
    {
        $this->addErrorReportsAction->execute(CreateVisitRequest::fromRequest($request));

        return ApiResponse::emptySuccess();
    }
}
