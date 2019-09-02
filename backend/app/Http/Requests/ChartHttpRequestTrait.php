<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\{Timestamp, TimestampAfter, IsWebsiteRelatedWithUser};

trait ChartHttpRequestTrait
{
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
                new TimestampAfter((string)$this->getStartDate())
            ],
            'filter.period' => [
                'required',
                'integer'
            ],
            'filter.website_id' => [
                'required',
                'integer',
                new IsWebsiteRelatedWithUser()
            ]
        ];
    }

    public function getStartDate(): string
    {
        return (string)$this->get('filter')['startDate'];
    }

    public function getEndDate(): string
    {
        return (string)$this->get('filter')['endDate'];
    }

    public function getPeriod(): string
    {
        return (string)$this->get('filter')['period'];
    }

    public function websiteId(): int
    {
        return (int)$this->get('filter')['website_id'];
    }
}
