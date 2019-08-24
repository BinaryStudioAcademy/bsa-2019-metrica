<?php

declare(strict_types=1);

namespace App\DataTransformer\Visits;

use App\Contracts\TableValue;
use App\DataTransformer\Traits\TableValueTrait;

final class TableVisit implements TableValue
{
    use TableValueTrait;

    private $parameter;
    private $parameterValue;
    private $total;
    private $percentage;

    public function __construct(
        string $parameter,
        string $parameterValue,
        string $total,
        float $percentage
    ) {
        $this->parameter = $parameter;
        $this->parameterValue = $parameterValue;
        $this->total = $total;
        $this->percentage = $percentage;
    }
}