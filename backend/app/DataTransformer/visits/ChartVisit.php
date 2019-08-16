<?php

namespace App\DataTransformer\visits;

class ChartVisit
{
    private $date;
    private $visits;

    public function __construct(string $date, int $visits)
    {
        $this->date = $date;
        $this->visits = $visits;
    }

}
