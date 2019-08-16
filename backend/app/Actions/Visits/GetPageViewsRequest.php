<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\Contracts\Common\DatePeriod;
use App\Exceptions\WebsiteNotFoundException;
use App\Http\Requests\Visits\GetPageViewsFilterHttpRequest;
use Illuminate\Support\Facades\Auth;


final class GetPageViewsRequest
{
    private $filterData;
    private $interval;
    private $websiteId;

    private function __construct(DatePeriod $filterData, int $interval, int $websiteId)
    {
        $this->filterData = $filterData;
        $this->interval = $interval;
        $this->websiteId = $websiteId;
    }

    public function getFilterData(): DatePeriod
    {
        return $this->filterData;
    }

    public function getInterval(): int
    {
        return (int) \round($this->interval/1000, 0);
    }

    public function getWebsiteId(): int
    {
        return $this->websiteId;
    }

    public static function fromRequest(GetPageViewsFilterHttpRequest $request)
    {
        $period = \App\Utils\DatePeriod::createFromTimestamp(
            $request->getStartDate(),
            $request->getEndDate()
        );

        $websiteId = Auth::user()->website->id;

        if(!$websiteId) {
            throw new WebsiteNotFoundException();
        }

        return new static(
            new \App\Model\Visits\PageViewsFilterData($period),
            $request->getPeriod(),
            Auth::user()->website->id
        );
    }
}
