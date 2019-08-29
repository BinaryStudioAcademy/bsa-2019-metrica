<?php

namespace App\Listeners;

use App\Events\VisitCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVisitsNotification
{
    public function __construct()
    {
    }

    public function handle(VisitCreated $event)
    {
        return [
            'page' => $event->visit->page->url,
            'visitor' => $event->visit->visitor_id,
            'time_notification' => $event->visit->created_at,
        ];
    }
}
