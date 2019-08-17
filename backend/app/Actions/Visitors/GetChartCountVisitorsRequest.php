<?php


namespace App\Actions\Visitors;


use App\Http\Requests\Visitors\GetChartCountVisitorsHttpRequest;

class GetChartCountVisitorsRequest
{
    private $startDate;
    private $endDate;

    private function __construct(int $startDate, int $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getStartDate(): int
    {
        return $this->startDate;
    }

    public function getEndDate(): int
    {
        return $this->endDate;
    }

    public static function fromRequest(GetChartCountVisitorsHttpRequest $request): self
    {
        return new static(
            $request->getStartDate(),
            $request->getEndDate()
        );
    }
}
