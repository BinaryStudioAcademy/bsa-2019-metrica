<?php

declare(strict_types=1);

namespace App\DataTransformer;

final class WidgetValue
{
    private $name;
    private $percent;

    public function __construct(string $name, float $percent)
    {
        $this->name = $name;
        $this->percent = $percent;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function percent(): float
    {
        return $this->percent;
    }
}
