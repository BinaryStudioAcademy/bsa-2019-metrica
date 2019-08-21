<?php
declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Http\Requests\Api\AverageSessionByDateIntervalHttpRequest;
use App\Model\Sessions\AverageSessionByIntervalFilterData;
use App\Utils\DatePeriod;

final class GetAverageSessionByIntervalRequest
{
    private $filterData;

    private function __construct(AverageSessionByIntervalFilterData $filterData)
    {
        $this->filterData = $filterData;
    }

    public function getFilterData(): AverageSessionByIntervalFilterData
    {
        return $this->filterData;
    }

    public static function fromRequest(AverageSessionByDateIntervalHttpRequest $request): self
    {
        $period = DatePeriod::createFromTimestamp(
            $request->getStartDate(),
            $request->getEndDate()
        );
        return new static(new AverageSessionByIntervalFilterData($period, $request->getTimeFrame()));
    }
}
