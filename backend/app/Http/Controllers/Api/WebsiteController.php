<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Website\AddWebsiteAction;
use App\Actions\Website\AddWebsiteRequest;
use App\Actions\Website\EditWebsiteAction;
use App\Actions\Website\EditWebsiteRequest;
use App\Http\Requests\AddWebsiteHttpRequest;
use App\Http\Requests\EditWebsiteHttpRequest;
use App\Http\Resources\WebsiteResource;
use App\Http\Response\ApiResponse;

class WebsiteController
{
    private $addWebsiteAction;

    public function __construct(AddWebsiteAction $addWebsiteAction)
    {
        $this->addWebsiteAction = $addWebsiteAction;
    }

    public function add(AddWebsiteHttpRequest $request): ApiResponse
    {
        $response = $this->addWebsiteAction->execute(
            AddWebsiteRequest::fromRequest($request)
        );

        return ApiResponse::success(new WebsiteResource($response->getWebsite()));
    }

    public function update(string $id, EditWebsiteHttpRequest $request, EditWebsiteAction $action ): ApiResponse
    {
        $response = $action->execute(
            new EditWebsiteRequest((int) $id, $request->name(), $request->singlePage())
        );

        return ApiResponse::success(new WebsiteResource($response->getWebsite()));
    }
}
