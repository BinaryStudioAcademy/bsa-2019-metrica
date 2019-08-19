<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\Contracts;
use App\DataTransformer\Traits\ButtonValueTrait;

final class ButtonValue implements Contracts\ButtonValue
{
    use ButtonValueTrait;

    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
