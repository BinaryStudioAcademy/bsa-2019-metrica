<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use Illuminate\Support\Collection;

final class GetSessionsResponse
{
    private $sessions;

    public function __construct(Collection $sessions)
    {
        $this->sessions = $sessions;
    }

    public function sessions(): Collection
    {
        return $this->sessions;
    }
}