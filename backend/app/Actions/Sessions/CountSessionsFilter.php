<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Actions\Sessions\CountSessionsRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

final class CountSessionsFilter
{
    private $startDate;
    private $endDate;
    private $visitorsIDs;

    public function __construct(
        CountSessionsRequest $request,
        Collection $visitorsIDsOfWebsite
    ) {
        $this->startDate = $request->startDate();
        $this->endDate = $request->endDate();
        $this->visitorsIDs = $visitorsIDsOfWebsite;
    }

    public function getVisitorsIDs()
    {
        return $this->visitorsIDs;
    }

    public function getStartDate()
    {
        return Carbon::createFromTimestamp($this->startDate)->toDateTimeString();
    }

    public function getEndDate()
    {
        return Carbon::createFromTimestamp($this->endDate)->toDateTimeString();
    }
}

