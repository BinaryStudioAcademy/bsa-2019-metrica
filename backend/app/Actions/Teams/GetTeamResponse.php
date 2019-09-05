<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use Illuminate\Support\Collection;

final class GetTeamResponse
{
    private $teamMembers;

    public function __construct(Collection $teamMembers)
    {
        $this->teamMembers = $teamMembers;
    }

    public function teamsData(): Collection
    {
        return $this->teamMembers;
    }
}