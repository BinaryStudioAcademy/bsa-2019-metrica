<?php

namespace App\Listeners;

use App\Events\VisitCreated;
use App\Notification\ActiveUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVisitsNotification
{
    public function __construct()
    {
    }

    public function handle(VisitCreated $event)
    {
        broadcast(new ActiveUser($event->visit));
    }
}
