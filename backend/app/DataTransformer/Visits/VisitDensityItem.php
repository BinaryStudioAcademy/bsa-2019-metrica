<?php

declare(strict_types=1);

namespace App\DataTransformer\Visits;

final class VisitDensityItem
{
    private $day;
    private $hour;
    private $visits;

    public function __construct(int $day, int $hour, int $visits)
    {
        $this->day = $day;
        $this->hour = $hour;
        $this->visits = $visits;
    }

    public function day(): int
    {
        return $this->day;
    }

    public function hour(): int
    {
        return $this->hour;
    }

    public function visits(): int
    {
        return $this->visits;
    }
}
