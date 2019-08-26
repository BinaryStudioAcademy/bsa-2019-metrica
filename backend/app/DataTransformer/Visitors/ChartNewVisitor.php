<?php

declare(strict_types=1);

namespace App\DataTransformer\Visitors;

use App\Contracts\ChartValue;
use App\DataTransformer\Traits\ChartValueTrait;

class ChartNewVisitor implements ChartValue
{
    use ChartValueTrait;

    private $date;
    private $value;

    public function __construct(string $date, int $count)
    {
        $this->date = $date;
        $this->value = $count;
    }
}
