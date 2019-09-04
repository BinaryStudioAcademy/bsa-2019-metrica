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
use App\Http\Requests\Team\GetPermittedMenuItemsHttpRequest;
use App\Http\Requests\Team\UpdatePermittedMenuItemsHttpRequest;
use App\Actions\Teams\InviteTeamMemberRequest;
use App\Actions\Teams\RemoveTeamMemberRequest;
use App\Actions\Teams\UpdatePermittedMenuItemsRequest;
use App\Actions\Teams\GetPermittedMenuItemsRequest;
use App\Actions\Teams\InviteTeamMemberAction;
use App\Actions\Teams\RemoveTeamMemberAction;
use App\Actions\Teams\GetPermittedMenuItemsAction;
use App\Http\Resources\PermittedMenuResource;
use App\Actions\Teams\UpdatePermittedMenuItemsAction;

final class TeamController extends Controller
{
    private $getTeamAction;
    private $inviteTeamMemberAction;
    private $removeTeamMemberAction;
    private $getPermittedMenuItemsAction;
    private $updatePermittedMenuItemsAction;

    public function __construct(
        GetTeamAction $getTeamAction,
        InviteTeamMemberAction $inviteTeamMemberAction,
        RemoveTeamMemberAction $removeTeamMemberAction,
        GetPermittedMenuItemsAction $getPermittedMenuItemsAction,
        UpdatePermittedMenuItemsAction $updatePermittedMenuItemsAction
    ) {
        $this->getTeamAction = $getTeamAction;
        $this->inviteTeamMemberAction = $inviteTeamMemberAction;
        $this->removeTeamMemberAction = $removeTeamMemberAction;
        $this->getPermittedMenuItemsAction = $getPermittedMenuItemsAction;
        $this->updatePermittedMenuItemsAction = $updatePermittedMenuItemsAction;
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

    public function getPermittedMenuItems(int $id, GetPermittedMenuItemsHttpRequest $request): ApiResponse
    {
        $response = $this->getPermittedMenuItemsAction->execute(
            GetPermittedMenuItemsRequest::fromRequest($request, $id)
        );

        return ApiResponse::success(
            new PermittedMenuResource($response->membersWithMenuItems())
        );
    }

    public function updatePermittedMenuItems(UpdatePermittedMenuItemsHttpRequest $request): ApiResponse
    {
        $response = $this->updatePermittedMenuItemsAction->execute(
            UpdatePermittedMenuItemsRequest::fromRequest($request)
        );
        return ApiResponse::success(
            new PermittedMenuResource($response->updatedMenuList())
        );
    }

}
