<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Actions\ErrorReport\GetErrorTableItemsAction;
use App\Http\Requests\ErrorReport\GetErrorTableItemsHttpRequest;
use App\Http\Resources\ErrorTableResource;
use App\Http\Response\ApiResponse;
use App\Actions\ErrorReport\GetErrorTableItemsRequest;

final class ErrorReportController extends Controller
{
    private $getErrorTableItemsAction;

    public function __construct(
        GetErrorTableItemsAction $getErrorTableItemsAction
    ) {
        $this->getErrorTableItemsAction = $getErrorTableItemsAction;
    }

    public function getErrorItemsByParameter(GetErrorTableItemsHttpRequest $request)
    {
        $response = $this->getErrorTableItemsAction->execute(
            GetErrorTableItemsRequest::fromRequest($request)
        );

        return ApiResponse::success(
            new ErrorTableResource(
                $response->getGroupedErrors()
            )
        );
    }
}