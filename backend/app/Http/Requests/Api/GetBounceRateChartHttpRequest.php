<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Request\ApiFormRequest;
use App\Http\Requests\ChartHttpRequestTrait;
use App\Rules\Timestamp;
use App\Rules\TimestampAfter;
use App\Rules\IsWebsiteRelatedWithUser;

final class GetBounceRateChartHttpRequest extends ApiFormRequest
{
    use ChartHttpRequestTrait;
}
    public function rules(): array
    {
        return [
            'filter' => 'required|array',
            'filter.startDate' => [
                'required',
                new Timestamp()
            ],
            'filter.endDate' => [
                'required',
                new Timestamp(),
                new TimestampAfter($this->get('filter')['startDate'])
            ],
            'filter.period' => [
                'required',
                'integer'
            ],
            'filter.website_id' => [
                'required',
                'integer',
                new IsWebsiteRelatedWithUser()
            ],
        ];
    }

    public function getStartDate(): string
    {
        return $this->get('filter')['startDate'];
    }

    public function getEndDate(): string
    {
        return $this->get('filter')['endDate'];
    }

    public function getPeriod(): string
    {
        return $this->get('filter')['period'];
    }

    public function websiteId(): int
    {
        return (int)$this->get('filter')['website_id'];
    }
}
