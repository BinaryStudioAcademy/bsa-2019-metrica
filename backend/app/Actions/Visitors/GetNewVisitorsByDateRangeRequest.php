<?php


namespace App\Actions\Visitors;


use App\Http\Requests\Visitors\GetNewVisitorsHttpRequest;

class GetNewVisitorsByDateRangeRequest
{
    private $startDate;
    private $endDate;
    private $period;

    private function __construct(int $startDate, int $endDate, int $period)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->period = $period;
    }

    public function getStartDate(): int
    {
        return $this->startDate;
    }

    public function getEndDate(): int
    {
        return $this->endDate;
    }

    public function getPeriod(): int
    {
        return $this->period;
    }

    public static function fromRequest(GetNewVisitorsHttpRequest $request): self
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate(),
            $request->getPeriod()
        );
    }
}
