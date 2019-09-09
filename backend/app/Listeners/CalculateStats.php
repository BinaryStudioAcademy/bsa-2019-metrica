<?php

namespace App\Listeners;

use App\Events\ActiveUserEvent;
use App\Events\StatsChangeEvent;
use App\Events\VisitCreated;

class CalculateStats
{
    public function handle(VisitCreated $event)
    {
        event(new StatsChangeEvent($event->visit));
    }
}
