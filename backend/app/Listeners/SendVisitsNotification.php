<?php

namespace App\Listeners;

use App\Events\ActiveUserEvent;
use App\Events\VisitCreated;

class SendVisitsNotification
{
    public function __construct()
    {
    }

    public function handle(VisitCreated $event)
    {
        event(new ActiveUserEvent($event->visit));
    }
}
