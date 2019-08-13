<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

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

    public function getPageViews(): ApiResponse
    {
        $response = $this->getPageViewsAction->execute();

        return ApiResponse::success(new PageResource($response->views()));
    }
}