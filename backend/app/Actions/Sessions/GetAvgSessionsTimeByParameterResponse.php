<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use Illuminate\Database\Eloquent\Collection;

final class GetAvgSessionsTimeByParameterResponse
{
    private $avgSessionsTimeCollection;

    public function __construct(Collection $avgSessionsTimeCollection)
    {
        $this->avgSessionsTimeCollection = $avgSessionsTimeCollection;
    }

    public function avgSessionsTimeCollection(): Collection
    {
        return $this->avgSessionsTimeCollection;
    }
}