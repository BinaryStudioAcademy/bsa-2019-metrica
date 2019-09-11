<?php

namespace App\Listeners;

use App\Events\SessionCreated;
use App\Events\StatsChangeEvent;

class SendSessionNotification
{
    public function handle(SessionCreated $event)
    {
        event(new StatsChangeEvent($event->session));
    }
}
