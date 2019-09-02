<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Teams\GetTeamAction;
use App\Actions\Teams\GetTeamRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Team\GetTeamHttpRequest;
use App\Http\Resources\TeamResource;
use App\Http\Response\ApiResponse;

final class TeamController extends Controller
{
    private $getTeamAction;

    public function __construct(GetTeamAction $getTeamAction)
    {
        $this->getTeamAction = $getTeamAction;
    }

    public function getTeam(GetTeamHttpRequest $request): ApiResponse
    {
        $response = $this->getTeamAction->execute(GetTeamRequest::fromRequest($request));

        return ApiResponse::success(new TeamResource($response));
    }
}