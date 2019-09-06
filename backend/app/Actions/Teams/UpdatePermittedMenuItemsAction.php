<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Repositories\Contracts\Teams\TeamRepository;

final class UpdatePermittedMenuItemsAction
{
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function execute(UpdatePermittedMenuItemsRequest $request): UpdatePermittedMenuItemsResponse
    {
        $usersWithPermittedMenuItems = $this->teamRepository->updatePermittedMenu(
            $request->websiteId(), $request->updateMenuList()
        );
        return new UpdatePermittedMenuItemsResponse($usersWithPermittedMenuItems);
    }
}
