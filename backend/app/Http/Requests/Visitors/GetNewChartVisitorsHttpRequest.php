<?php


namespace App\Http\Requests\Visitors;


class GetNewChartVisitorsHttpRequest extends AbstractVisitorsFilterHttpRequest
{
    public function rules(): array
    {
        return array_merge(
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
                "filter.period" => [
                    'required',
                    'integer'
                ]
            ]
        );
    }

    public function getStartDate(): int
    {
        return (int)$this->get('filter')['startDate'];
    }

    public function getEndDate(): int
    {
        return (int)$this->get('filter')['endDate'];
    }

    public function getPeriod(): int
    {
        return (int)$this->get('filter')['period'];
    }
}
