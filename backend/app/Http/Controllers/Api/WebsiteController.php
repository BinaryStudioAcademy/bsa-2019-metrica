<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Website\AddWebsiteAction;
use App\Actions\Website\AddWebsiteRequest;
use App\Http\Requests\AddWebsiteHttpRequest;
use App\Http\Resources\WebsiteResource;
use Illuminate\Http\JsonResponse;

class WebsiteController
{
    private $addWebsiteAction;

    public function __construct(AddWebsiteAction $addWebsiteAction)
    {
        $this->addWebsiteAction = $addWebsiteAction;
    }

    public function add(AddWebsiteHttpRequest $request): JsonResponse
    {
        $response = $this->addWebsiteAction->execute(
            AddWebsiteRequest::fromRequest($request)
        );

        return response()->json(new WebsiteResource($response->getWebsite()), 201);
    }
}
