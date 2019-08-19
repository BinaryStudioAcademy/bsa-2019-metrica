<?php


namespace App\Http\Requests\Api;

use App\Http\Request\ApiFormRequest;

class GetVisitorsBounceRateHttpRequest extends ApiFormRequest
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
                'filter.timeFrame' => [
                    'required',
                    'integer',
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

    public function getTimeFrame(): int
    {
        return (int) $this->get('filter')['timeFrame'];
    }
}
