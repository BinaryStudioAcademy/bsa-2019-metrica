<?php


namespace App\Http\Requests\Visitors;


class GetNewVisitorCountFilterHttpHttpRequest extends AbstractVisitorsFilterHttpRequest
{
    public function rules(): array
    {
        return  array_merge(
            parent::rules(),
            [
                "filter.startDate" => [
                    'required',
                    'integer',
                ],
                "filter.endDate" => [
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
}
