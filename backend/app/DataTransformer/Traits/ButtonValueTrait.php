<?php

declare(strict_types=1);

namespace App\DataTransformer\Traits;

trait ButtonValueTrait
{
    public function value(): string
    {
        return $this->value;
    }
}