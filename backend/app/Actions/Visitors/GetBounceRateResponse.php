<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

final class GetBounceRateResponse
{
    private $bounceRate;

    public function __construct(float $bounceRate)
    {
        $this->bounceRate = $bounceRate;
    }

    public function bounceRate(): float
    {
        return $this->bounceRate;
    }
}