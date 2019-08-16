<?php

declare(strict_types=1);

namespace App\Actions\Sessions;
use Illuminate\Support\Collection;

final class GetAvgSessionResponse
{
    private $avgSession;

    public function __construct(Collection $avgSession)
    {
        $this->avgSession = $avgSession;
    }

    public function avgSession(): int
    {
        return (int) $this->avgSession->first()->avg;
    }
}