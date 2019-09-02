<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Repositories\Contracts\Teams\TeamRepository;

final class GetTeamAction
{
    private $repository;

    public function __construct(TeamRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetTeamRequest $request): GetTeamResponse
    {
        $websiteId = $request->websiteId();
        $response = $this->repository->getTeamMembers($websiteId);

        return new GetTeamResponse($response);
    }
}