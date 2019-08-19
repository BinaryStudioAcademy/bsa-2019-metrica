<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use Illuminate\Support\Collection;

final class GetAvgSessionTimeByParameterResponse
{
    private $tableSessionCollection;

    public function __construct(Collection $tableSessionCollection)
    {
        $this->tableSessionCollection = $tableSessionCollection;
    }

    public function tableSessionCollection(): Collection
    {
        return $this->tableSessionCollection;
    }
}