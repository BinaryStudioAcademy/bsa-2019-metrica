<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Repositories\Contracts\WebsiteRepository;

final class GetPermittedMenuItemsAction
{
    private $websiteRepository;

    public function __construct(WebsiteRepository $websiteRepository)
    {
        $this->websiteRepository = $websiteRepository;
    }

    public function execute(GetPermittedMenuItemsRequest $request): GetPermittedMenuItemsResponse
    {
        $usersWithPermittedMenuItems = $this->websiteRepository->getUsersWithPermittedMenu(
            $request->websiteId()
        );
        return new GetPermittedMenuItemsResponse($usersWithPermittedMenuItems);
    }
}
