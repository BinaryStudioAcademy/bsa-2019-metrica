<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;


use App\Actions\Website\GetCurrentUserWebsiteAction;
use App\Actions\Website\AddWebsiteAction;
use App\Actions\Website\AddWebsiteRequest;
use App\Http\Requests\AddWebsiteHttpRequest;
use App\Http\Resources\WebsiteResource;
use App\Http\Response\ApiResponse;

class WebsiteController
{
    private $addWebsiteAction;
    private $getCurrentUserWebsiteAction;

    public function __construct(
        AddWebsiteAction $addWebsiteAction,
        GetCurrentUserWebsiteAction $getCurrentUserWebsiteAction
    )
    {
        $this->addWebsiteAction = $addWebsiteAction;
        $this->getCurrentUserWebsiteAction = $getCurrentUserWebsiteAction;
    }

    public function add(AddWebsiteHttpRequest $request): ApiResponse
    {
        $response = $this->addWebsiteAction->execute(
            AddWebsiteRequest::fromRequest($request)
        );

        return ApiResponse::success(new WebsiteResource($response->getWebsite()));
    }

    public function getCurrentUserWebsite(): ApiResponse
    {
        $response = $this->getCurrentUserWebsiteAction->execute();
        return ApiResponse::success(new WebsiteResource($response->website()));
    }
}
