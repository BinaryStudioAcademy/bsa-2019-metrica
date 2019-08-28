<?php

declare(strict_types=1);

namespace App\DataTransformer\Visitors;

use App\Contracts;
use App\DataTransformer\Traits\TableValueTrait;

final class BounceRateVisitors implements Contracts\VisitorsBounceRateByParameter
{
    use TableValueTrait;

    private $parameter;
    private $parameterValue;
    private $bounceRate;

    public function __construct(
        string $parameter,
        string $parameterValue,
        float $bounceRate
    ) {
        $this->parameter = $parameter;
        $this->parameterValue = $parameterValue;
        $this->bounceRate = $bounceRate;
    }

    public function bounceRate(): float
    {
        return $this->bounceRate;
    }
}