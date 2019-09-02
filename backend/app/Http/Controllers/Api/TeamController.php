<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Teams\GetTeamAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Http\Response\ApiResponse;

final class TeamController extends Controller
{
    private $getTeamAction;

    public function __construct(GetTeamAction $getTeamAction)
    {
        $this->getTeamAction = $getTeamAction;
    }

    public function getTeam(): ApiResponse
    {
        $response = $this->getTeamAction->execute();

        return ApiResponse::success(new TeamResource($response));
    }
}