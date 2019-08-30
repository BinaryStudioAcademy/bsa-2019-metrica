<?php

declare(strict_types=1);

namespace App\Http\Requests\Visitor;

use App\Http\Request\ApiFormRequest;
use App\Rules\Timestamp;
use App\Rules\TimestampAfter;

final class GetNewVisitorCountFilterHttpRequest extends ApiFormRequest
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

    public function getStartDate(): int
    {
        return (int) $this->get('filter')['startDate'];
    }

    public function getEndDate(): int
    {
        return (int) $this->get('filter')['endDate'];
    }
}
