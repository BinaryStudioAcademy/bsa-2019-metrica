<?php

namespace App\Actions\System;

use Illuminate\Support\Collection;

class GetMostPopularOsResponse
{
    private $systems;

    public function __construct(Collection $systems)
    {
        $this->systems = $systems;
    }

    public function getMostPopularSystems(): Collection
    {
        return $this->systems;
    }
}
