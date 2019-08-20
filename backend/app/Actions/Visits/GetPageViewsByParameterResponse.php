<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use Illuminate\Database\Eloquent\Collection;

final class GetPageViewsByParameterResponse
{
    private $visits;

    public function __construct(Collection $visits)
    {
        $this->visits = $visits;
    }

    public function visits(): Collection
    {
        return $this->visits;
    }

}