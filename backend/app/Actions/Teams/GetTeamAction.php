<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Repositories\Contracts\Teams\TeamRepository;
use Illuminate\Support\Facades\Auth;

final class GetTeamAction
{
    private $repository;

    public function __construct(TeamRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): GetTeamResponse
    {
        $id = Auth::user()->website->id();

        $response = $this->repository->getTeamMembers($id);

        return new GetTeamResponse($response);
    }
}