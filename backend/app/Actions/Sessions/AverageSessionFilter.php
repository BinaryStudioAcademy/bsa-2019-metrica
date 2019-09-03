<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use Illuminate\Support\Collection;

final class AverageSessionFilter
{
    private $startDate;
    private $endDate;
    private $visitorsIDs;
    private $websiteId;

    public function __construct(
        GetAvgSessionRequest $request,
        Collection $visitorsIDsOfWebsite
    ) {
        $this->startDate = $request->period()->getStartDate();
        $this->endDate = $request->period()->getEndDate();
        $this->visitorsIDs = $visitorsIDsOfWebsite;
        $this->websiteId = $request->websiteId();
    }

    public function getVisitorsIDs()
    {
        return $this->visitorsIDs;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}
