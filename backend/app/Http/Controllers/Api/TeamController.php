<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Teams\GetTeamAction;
use App\Actions\Teams\GetTeamRequest;
use App\Http\Requests\Team\GetTeamHttpRequest;
use App\Http\Resources\TeamResource;
use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Http\Requests\Team\InviteTeamMemberHttpRequest;
use App\Http\Requests\Team\RemoveTeamMemberHttpRequest;
use App\Actions\Teams\InviteTeamMemberRequest;
use App\Actions\Teams\RemoveTeamMemberRequest;
use App\Actions\Teams\InviteTeamMemberAction;
use App\Actions\Teams\RemoveTeamMemberAction;

final class TeamController extends Controller
{
    private $getTeamAction;
    private $inviteTeamMemberAction;
    private $removeTeamMemberAction;

    public function __construct(
        GetTeamAction $getTeamAction,
        InviteTeamMemberAction $inviteTeamMemberAction,
        RemoveTeamMemberAction $removeTeamMemberAction
    ) {
        $this->getTeamAction = $getTeamAction;
        $this->inviteTeamMemberAction = $inviteTeamMemberAction;
        $this->removeTeamMemberAction = $removeTeamMemberAction;
    }

    public function getTeam(GetTeamHttpRequest $request): ApiResponse
    {
        $response = $this->getTeamAction->execute(GetTeamRequest::fromRequest($request));

        return ApiResponse::success(new TeamResource($response->teamsData()));
    }

    public function inviteTeamMember(InviteTeamMemberHttpRequest $request): ApiResponse
    {
        $this->inviteTeamMemberAction->execute(
            InviteTeamMemberRequest::fromRequest($request)
        );
        return ApiResponse::emptySuccess()->setStatusCode(201);
    }

    public function removeTeamMember(int $id, RemoveTeamMemberHttpRequest $request): ApiResponse
    {
        $this->removeTeamMemberAction->execute(
            RemoveTeamMemberRequest::fromRequest($request, $id)
        );
        return ApiResponse::emptySuccess()->setStatusCode(204);
    }
}
