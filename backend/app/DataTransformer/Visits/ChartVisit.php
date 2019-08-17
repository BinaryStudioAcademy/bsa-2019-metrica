<?php

namespace App\DataTransformer\Visits;

class ChartVisit
{
    private $date;
    private $visits;

    public function __construct(string $date, int $visits)
    {
        $this->date = $date;
        $this->visits = $visits;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getVisits(): int
    {
        return $this->visits;
    }
}
