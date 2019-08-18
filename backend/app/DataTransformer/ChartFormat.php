<?php

declare(strict_types=1);

namespace App\DataTransformer;

final class ChartFormat
{
    private $date;
    private $value;

    public function __construct(string $date, string $value)
    {
        $this->date = $date;
        $this->value = $value;
    }

    public function date(): string
    {
        return $this->date;
    }

    public function value(): string
    {
        return $this->value;
    }
}
