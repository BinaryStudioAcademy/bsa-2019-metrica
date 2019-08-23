<?php

namespace App\Notifications;

use App\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailSuccessRegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $user;
    private $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $link = url("/signup/verify-email?token={$this->token}");
        return (new MailMessage)
            ->subject('Confirmation of registration')
            ->line("Dear {$this->user->name},")
            ->line("Thanks for getting started with Metrica. We need a little more information to complete your
            registration, including confirmation of your email address. Click below to confirm your email address.")
            ->action('Verify your account', $link)
            ->salutation("Thanks, Metrica Support");
    }


    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
