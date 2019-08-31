<?php

namespace App\Events;

use App\Entities\Visit;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Event;

class ActiveUserEvent extends Event implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $visit;

    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('active-users.' . $this->visit->page->website_id);
    }

    public function broadcastWith()
    {
        return [
            'url' => $this->visit->page->url,
            'visitor' => $this->visit->visitor_id,
            'date' => $this->visit->created_at,
        ];
    }
}
