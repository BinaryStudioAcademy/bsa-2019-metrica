<?php

declare(strict_types=1);

namespace App\Actions\Teams;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
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

    public function execute(RemoveTeamMemberRequest $request): void
    {
        $website = $this->websiteRepository->getById($request->websiteId());

        $teamMember = $this->userRepository->getById($request->memberId());

        $this->websiteRepository->removeMemberFromWebsiteTeam($teamMember, $website->id);

        $teamMember->notify(new TeamMemberRemoved($website));
    }
}
