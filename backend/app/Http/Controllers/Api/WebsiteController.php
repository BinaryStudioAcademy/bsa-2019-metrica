<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Website\GetCurrentUserWebsiteAction;
use App\Actions\Website\AddWebsiteAction;
use App\Actions\Website\AddWebsiteRequest;
use App\Actions\Website\EditWebsiteAction;
use App\Actions\Website\EditWebsiteRequest;
use App\Http\Requests\Website\AddWebsiteHttpRequest;
use App\Http\Requests\Website\EditWebsiteHttpRequest;
use App\Http\Resources\WebsiteResource;
use App\Http\Response\ApiResponse;

final class WebsiteController
{
    private $addWebsiteAction;
    private $getCurrentUserWebsiteAction;

    public function __construct(
        AddWebsiteAction $addWebsiteAction,
        GetCurrentUserWebsiteAction $getCurrentUserWebsiteAction
    ) {
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

    public function update(string $id, EditWebsiteHttpRequest $request, EditWebsiteAction $action): ApiResponse
    {
        $response = $action->execute(
            new EditWebsiteRequest((int) $id, $request->name(), $request->singlePage())
        );

        return ApiResponse::success(new WebsiteResource($response->getWebsite()));
    }

    public function getCurrentUserWebsite(string $websiteId): ApiResponse
    {
        $response = $this->getCurrentUserWebsiteAction->execute($websiteId);
        return ApiResponse::success(new WebsiteResource($response->website()));
    }
}
