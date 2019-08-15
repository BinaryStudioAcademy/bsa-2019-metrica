<?php

declare(strict_types=1);

namespace App\DataTransformer;

use Illuminate\Database\Eloquent\Collection;

interface DataTransformerInterface
{
    public function modelsFromRawResults(): Collection;
}
