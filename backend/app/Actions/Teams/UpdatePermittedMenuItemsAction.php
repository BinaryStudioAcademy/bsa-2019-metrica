<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Repositories\Contracts\Teams\TeamRepository;
use App\DataTransformer\Teams\TeamMember;

final class UpdatePermittedMenuItemsAction
{
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function execute(UpdatePermittedMenuItemsRequest $request): UpdatePermittedMenuItemsResponse
    {
        $this->teamRepository->updatePermittedMenu(
            $request->websiteId(), $request->updateMenuList()
        );

        $members = $this->teamRepository->getTeamMembers($request->websiteId());

        return new UpdatePermittedMenuItemsResponse($members->map(function ($item) {
            return new TeamMember(
                $item->id,
                $item->name,
                $item->email,
                $item->pivot->permitted_menu
            );
        }));
    }
}
