<?php

namespace App\Notifications;

use App\Entities\Visit;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewVisitsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $visit;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('active-users.' . $this->visit->page->website_id);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'page' => $this->visit->page->url,
            'visitor' => $this->visit->visitor_id,
            'time_notification' => $this->visit->created_at,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage(
            $this->toArray($notifiable)
        );
    }
}
