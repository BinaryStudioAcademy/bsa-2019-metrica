<?php

declare(strict_types=1);

namespace App\DataTransformer\Traits;

trait ChartValueTrait
{
    public function date(): string
    {
        return $this->date;
    }

    public function value(): string
    {
        return $this->value;
    }
}