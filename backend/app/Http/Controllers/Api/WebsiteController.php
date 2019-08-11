<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Website\AddWebsiteAction;
use App\Http\Requests\Api\AddWebsiteHttpRequest;
use App\Http\Response\ApiResponse;
use App\Http\Resources\WebsiteResource;

class WebsiteController extends Controller
{

    private $addWebsiteActionAction;

    public function __construct(AddWebsiteActionAction $addWebsiteActionAction)
    {
        $this->addWebsiteActionAction = $addWebsiteActionAction;
    }

    public function create(AddWebsiteHttpRequest $request): ApiResponse
    {
        $response = $this->addWebsiteActionAction->execute(
            AddWebsiteHttpRequest::fromHttpRequest($request)
        );

        return ApiResponse::success(new WebsiteResource($response->website()));
    }
}
