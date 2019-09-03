<?php

declare(strict_types=1);

namespace App\Actions\Teams;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\TeamMemberInvited;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\Contracts\UserRepository;
use App\Entities\User;

final class InviteTeamMemberAction
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

    public function execute(InviteTeamMemberRequest $request): void
    {
        $website = $this->websiteRepository->getById($request->websiteId());
        $password = '';
        $existingUser = $this->userRepository->getByEmail($request->email());

        if (!$existingUser) {
            $password = Str::random(8);
            $user = new User([
                'name' => '',
                'email' => $request->email(),
                'password' => Hash::make($password)
            ]);
            $teamMember = $this->userRepository->save($user);
        } else {
            $teamMember = $existingUser;
        }

        $this->websiteRepository->addTeamMemberToWebsite($teamMember, $website->id);

        $teamMember->notify(new TeamMemberInvited($website, $password));
    }
}
