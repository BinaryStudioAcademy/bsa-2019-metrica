<?php

declare(strict_types=1);

namespace App\Http\Controllers\OpenApi;

use App\Actions\ErrorReport\AddErrorReportAction;
use App\Actions\ErrorReport\AddErrorReportActionRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ErrorReport\AddErrorReportsHttpRequest;
use App\Http\Response\ApiResponse;

final class ErrorReportController extends Controller
{
    private $addErrorReportsAction;

    public function __construct(AddErrorReportAction $addErrorReportsAction)
    {
        $this->addErrorReportsAction = $addErrorReportsAction;
    }

    public function addErrorReports(AddErrorReportsHttpRequest $request): ApiResponse
    {
        $this->addErrorReportsAction->execute(AddErrorReportActionRequest::fromRequest($request));

        return ApiResponse::emptySuccess();
    }
}
