<?php

declare(strict_types=1);

namespace App\DataTransformer\Visits;

use App\Contracts\ChartValue;
use App\DataTransformer\Traits\ChartValueTrait;

final class ChartVisit implements ChartValue
{
    use ChartValueTrait;

    private $date;
    private $value;

    public function __construct(string $date, int $value)
    {
        $this->date = $date;
        $this->value = $value;
    }
}
