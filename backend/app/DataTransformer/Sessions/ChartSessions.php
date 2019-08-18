<?php

namespace App\DataTransformer\Sessions;

class ChartSessions
{
    private $date;
    private $sessions;

    public function __construct(string $date, int $sessions)
    {
        $this->date = $date;
        $this->sessions = $sessions;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getSessions(): int
    {
        return $this->sessions;
    }
}
