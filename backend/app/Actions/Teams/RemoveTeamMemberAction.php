<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Notifications\TeamMemberRemoved;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\Contracts\UserRepository;

final class RemoveTeamMemberAction
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

    public function execute($userId): void
    {
        $teamMember = $this->userRepository->getById($userId);

        $website = $this->websiteRepository->removeMemberFromWebsiteTeam($teamMember);

        $teamMember->notify(new TeamMemberRemoved($website));
    }
}
