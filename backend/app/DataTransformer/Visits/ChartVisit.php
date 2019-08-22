<?php

namespace App\DataTransformer\Visits;

use App\Contracts\ChartValue;

class ChartVisit implements ChartValue
{
    private $date;
    private $value;

    public function __construct(string $date, int $value)
    {
        $this->date = $date;
        $this->value = $value;
    }

    public function date(): string
    {
        return $this->date;
    }

    public function value(): string
    {
        return (string)$this->value;
    }
}
