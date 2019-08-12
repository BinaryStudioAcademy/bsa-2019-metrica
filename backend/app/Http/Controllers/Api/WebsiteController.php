<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Response\ApiResponse;
use App\Actions\Websites\GetCurrentUserWebsiteAction;

class WebsiteController
{
    private $getCurrentUserWebsiteAction;

    public function __construct(GetCurrentUserWebsiteAction $getCurrentUserWebsiteAction)
    {
        $this->getCurrentUserWebsiteAction = $getCurrentUserWebsiteAction;
    }

    public function getCurrentUserWebsite(): ApiResponse
    {
        $response = $this->getCurrentUserWebsiteAction->execute();
        return ApiResponse::success(new WebsiteResource($response->website()));
    }
}