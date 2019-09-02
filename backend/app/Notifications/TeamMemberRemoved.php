<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Entities\User;
use App\Entities\Website;

class TeamMemberInvited extends Notification
{
    use Queueable;

    protected $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Removing from team')
                    ->line('You have been removed from team of website '.$this->website->domain.' in Metrica');
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
