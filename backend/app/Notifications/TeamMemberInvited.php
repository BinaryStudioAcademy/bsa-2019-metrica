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
    protected $password;

    public function __construct(Website $website, string $password)
    {
        $this->website = $website;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $greeting = 'Owner of website '.$this->website->domain.' invited you to Metrica.';

        return (new MailMessage)
                    ->subject('Invitation to Metrica')
                    ->greeting($greeting)
                    ->line($this->getCredentialsMessage($notifiable, $this->password))
                    ->action('Go right now', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [];
    }

    private function getCredentialsMessage($notifiable, string $password): string
    {
        if ($password) {
            return 'Your login: '.$notifiable->email.', password: '.$password;
        }
        return 'Login with your credentials';
    }

}
