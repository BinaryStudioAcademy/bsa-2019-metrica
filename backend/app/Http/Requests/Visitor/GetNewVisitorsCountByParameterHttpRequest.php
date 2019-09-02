<?php

declare(strict_types=1);

namespace App\Http\Requests\Visitor;

use App\Http\Request\ApiFormRequest;
use App\Rules\Parameter;
use App\Rules\Timestamp;
use App\Rules\TimestampAfter;
use App\Rules\IsWebsiteRelatedWithUser;

final class GetNewVisitorsCountByParameterHttpRequest extends ApiFormRequest
{
    public function rules()
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
            'filter.parameter' => [
                'required',
                new Parameter()
            ],
            'filter.website_id' => [
                'required',
                'integer',
                new IsWebsiteRelatedWithUser()
            ],
        ];
    }
    public function startDate(): string
    {
        return $this->get('filter')['startDate'];
    }
    public function endDate(): string
    {
        return $this->get('filter')['endDate'];
    }

    public function parameter(): string
    {
        return $this->get('filter')['parameter'];
    }

    public function websiteId(): int
    {
        return (int)$this->get('filter')['website_id'];
    }
}