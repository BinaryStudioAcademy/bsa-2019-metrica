<?php

declare(strict_types=1);

namespace App\DataTransformer;

final class SpeedOverviewTableValue
{
    private $parameter;
    private $parameterValue;
    private $timing;

    public function __construct(
        string $parameter,
        string $parameterValue,
        float $timing
    ) {
        $this->parameter = $parameter;
        $this->parameterValue = $parameterValue;
        $this->timing = $timing;
    }
    public function parameter(): string
    {
        return $this->parameter;
    }

    public function parameterValue(): string
    {
        return $this->parameterValue;
    }

    public function timing(): float
    {
        return $this->timing;
    }
}
