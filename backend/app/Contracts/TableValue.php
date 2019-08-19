<?php

namespace App\Contracts;

interface TableValue
{
    public function parameter(): string;

    public function parameterValue(): string;

    public function total(): string;

    public function percentage(): float;
}