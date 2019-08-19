<?php

namespace App\Contracts;

interface ChartValue
{
    public function date(): string;

    public function value(): string;
}