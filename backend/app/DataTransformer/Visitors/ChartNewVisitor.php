<?php

declare(strict_types=1);

namespace App\DataTransformer\Visitors;

use App\Contracts\ChartValue;

final class ChartNewVisitor implements ChartValue
{
    private $period;
    private $count;

    public function __construct(string $period, int $count)
    {
        $this->period = $period;
        $this->count = $count;
    }
    public function date(): string
    {
        return $this->period;
    }
    public function value(): string
    {
        return $this->count;
    }
}
