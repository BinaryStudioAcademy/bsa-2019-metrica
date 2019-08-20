<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Request\ApiFormRequest;
use App\Rules\Timestamp;
use App\Rules\TimestampAfter;

final class GetPageViewsCountFilterHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return  [
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
        ];
    }

    public function getFilterArray(): array
    {
        return $this->get('filter');
    }

    public function getStartDate(): string
    {
        return (string) $this->get('filter')['startDate'];
    }

    public function getEndDate(): string
    {
        return (string) $this->get('filter')['endDate'];
    }
}
