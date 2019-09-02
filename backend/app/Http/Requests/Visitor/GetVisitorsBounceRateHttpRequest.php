<?php

declare(strict_types=1);

namespace App\Http\Requests\Visitor;

use App\Http\Request\ApiFormRequest;
use App\Rules\IsWebsiteRelatedWithUser;

final class GetVisitorsBounceRateHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return  array_merge(
            [
                'filter' => 'required|array',
                'filter.startDate' => [
                    'required',
                    'integer',
                ],
                'filter.endDate' => [
                    'required',
                    'integer',
                ],
                'filter.period' => [
                    'required',
                    'integer',
                ],
                'filter.website_id' => [
                    'required',
                    'integer',
                    new IsWebsiteRelatedWithUser()
                ],
            ]
        );
    }

    public function getStartDate(): int
    {
        return (int) $this->get('filter')['startDate'];
    }

    public function getEndDate(): int
    {
        return (int) $this->get('filter')['endDate'];
    }

    public function getPeriod(): int
    {
        return (int) $this->get('filter')['period'];
    }

    public function websiteId(): int
    {
        return (int)$this->get('filter')['website_id'];
    }
}
