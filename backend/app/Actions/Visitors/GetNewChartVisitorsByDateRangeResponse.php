<?php


namespace App\Actions\Visitors;


use Illuminate\Support\Collection;

class GetNewChartVisitorsByDateRangeResponse
{
    private $visitorsByDateRange;

    public function __construct(Collection $visitorsByDateRange)
    {
        $this->visitorsByDateRange = $visitorsByDateRange;
    }

    public function getVisitorsByDateRange(): Collection
    {
        return $this->visitorsByDateRange;
    }
}
