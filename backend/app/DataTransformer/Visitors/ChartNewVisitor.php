<?php


namespace App\DataTransformer\Visitors;


class ChartNewVisitor
{
    private $period;
    private $count;

    public function __construct(string $period, int $count)
    {
        $this->period = $period;
        $this->count = $count;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

    public function getCount(): int
    {
        return $this->count;
    }

}
