<?php

namespace App\Notification;

use App\Entities\Visit;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ActiveUser extends Notification implements ShouldQueue
{
    use Queueable;

    public $visit;

    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('active-users.' . $this->visit->page->website_id);
    }

    public function toArray($notifiable)
    {
        return [
            'page' => $this->visit->page->url,
            'visitor' => $this->visit->visitor_id,
            'date' => $this->visit->created_at,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage(
            $this->toArray($notifiable)
        );
    }
}
