<?php

namespace App\Contracts;

interface VisitorsBounceRateByParameter
{
    public function parameter(): string;

    public function parameterValue(): string;

    public function bounceRate(): float;
}