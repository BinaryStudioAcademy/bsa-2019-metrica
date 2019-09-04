<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\TeamMemberInvited;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\Contracts\UserRepository;
use App\Entities\User;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\RegisterRequest;

final class InviteTeamMemberAction
{
    private $userRepository;
    private $websiteRepository;
    private $registerAction;

    public function __construct(
        UserRepository $userRepository,
        WebsiteRepository $websiteRepository,
        RegisterAction $registerAction
    ) {
        $this->userRepository = $userRepository;
        $this->websiteRepository = $websiteRepository;
        $this->registerAction = $registerAction;
    }

    public function execute(InviteTeamMemberRequest $request): void
    {
        $website = $this->websiteRepository->getById($request->websiteId());
        $password = '';
        $teamMember = $this->userRepository->getByEmail($request->email());

        if (!$teamMember) {
            $password = Str::random(8);
            $teamMember = $this->registerNewteamMember('', $request->email(), $password);
        }

        $this->websiteRepository->addTeamMemberToWebsite($teamMember, $website->id);

        $teamMember->notify(new TeamMemberInvited($website, $password));
    }

    private function registerNewteamMember($name, $email, $password): User
    {
        $request = new RegisterRequest($name, $email, $password);

        $email = $this->registerAction->execute($request)->getEmail();

        return $this->userRepository->getByEmail($email);
    }
}
