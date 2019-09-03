<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\Contracts\UserRepository;

final class GetPermittedMenuItemsAction
{
    private $userRepository;
    private $websiteRepository;

    public function __construct(
        UserRepository $userRepository,
        WebsiteRepository $websiteRepository
    ) {
        $this->userRepository = $userRepository;
        $this->websiteRepository = $websiteRepository;
    }

    public function execute(GetPermittedMenuItemsRequest $request): GetPermittedMenuItemsResponse
    {
        $website = $this->websiteRepository->getById($request->websiteId());

        $teamMember = $this->userRepository->getById($request->memberId());

        $permittedItems = $this->websiteRepository->getPermittedMenuItems($teamMember, $website->id);

        return new GetPermittedMenuItemsResponse(
            $permittedItems, $website->id, $teamMember->id
        );
    }
}
