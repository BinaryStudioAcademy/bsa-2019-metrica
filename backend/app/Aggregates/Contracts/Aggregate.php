<?php
declare(strict_types=1);

namespace App\Aggregates\Contracts;

interface Aggregate
{
    public function toArray(): array;
}
