<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Repositories\Contracts\SessionRepository;

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