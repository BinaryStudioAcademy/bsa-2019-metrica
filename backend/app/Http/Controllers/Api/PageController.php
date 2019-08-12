<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\GetByIdRequest;
use App\Actions\Pages\GetPageViewsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Http\Response\ApiResponse;

final class PageController extends Controller
{
    private $getPageViewsAction;

    public function __construct(GetPageViewsAction $getPageViewsAction)
    {
        $this->getPageViewsAction = $getPageViewsAction;
    }

    public function getPageViews(int $id): ApiResponse
    {
        $response = $this->getPageViewsAction->execute(new GetByIdRequest($id));

        return ApiResponse::success(new PageResource($response->previews()));
    }
}