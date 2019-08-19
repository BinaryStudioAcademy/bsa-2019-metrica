<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\Contracts;
use App\DataTransformer\Traits\ChartValueTrait;

final class ChartValue implements Contracts\ChartValue
{
    use ChartValueTrait;

    private $date;
    private $value;

    public function __construct(string $date, string $value)
    {
        $this->date = $date;
        $this->value = $value;
    }
}
