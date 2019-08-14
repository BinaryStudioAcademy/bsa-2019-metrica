<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Entities\Session;
use App\Repositories\Contracts\SessionRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class GetSessionsAction
{
    private $sessionRepository;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function execute(): GetSessionsResponse
    {
        $getMySessions = $this->sessionRepository->getCollection();

        return new GetSessionsResponse($getMySessions);
    }
}