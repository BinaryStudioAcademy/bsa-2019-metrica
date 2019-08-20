<?php

declare(strict_types=1);

namespace App\DataTransformer\Sessions;

final class TableSession
{
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

    public function parameter(): string
    {
        return $this->parameter;
    }

    public function parameterValue(): string
    {
        return $this->parameterValue;
    }

    public function total(): string
    {
        return $this->total;
    }

    public function percentage(): float
    {
        return $this->percentage;
    }
}