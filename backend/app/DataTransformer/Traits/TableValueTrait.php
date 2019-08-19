<?php

declare(strict_types=1);

namespace App\DataTransformer\Traits;

trait TableValueTrait
{
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