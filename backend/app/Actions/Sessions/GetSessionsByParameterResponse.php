<?php

namespace App\Actions\Sessions;

use Illuminate\Support\Collection;

class GetSessionsByParameterResponse
{
    private $sessions;

    public function __construct(Collection $sessions)
    {
        $this->sessions = $sessions;
    }

    public function getSessionsByParameter(): Collection
    {
        return $this->sessions;
    }
}