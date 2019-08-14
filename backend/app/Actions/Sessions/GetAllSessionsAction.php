<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Entities\Session;
use App\Repositories\Contracts\SessionRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class GetAllSessionsAction
{
    private $sessionRepository;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function execute(): GetAllSessionsResponse
    {
        $sessions = $this->sessionRepository->getCollection();

        return new GetAllSessionsResponse($sessions);
    }
}