<?php

declare(strict_types=1);

namespace App\DataTransformer\Sessions;

use Carbon\Carbon;

final class ChartSessionValue
{
    private $start_session;
    private $end_session;

    public function __construct(Carbon $startSession, Carbon $endSession)
    {
        $this->start_session = $startSession;
        $this->end_session = $endSession;
    }

    public function getStartSession(): Carbon
    {
        return $this->start_session;
    }

    public function getEndSession(): Carbon
    {
        return $this->end_session;
    }
}