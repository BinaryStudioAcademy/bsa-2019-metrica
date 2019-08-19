<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use Illuminate\Support\Collection;

final class CountSessionsResponse
{
    private $countSessions;

    public function __construct(int $countSessions)
    {
        $this->countSessions = $countSessions;
    }

    public function countSessions(): int
    {
        return (int) $this->countSessions;
    }
}