<?php

declare(strict_types=1);

namespace App\DataTransformer\ErrorReport;

use App\Contracts\ChartValue;
use App\DataTransformer\Traits\ChartValueTrait;

final class ChartCountErrors implements ChartValue
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
