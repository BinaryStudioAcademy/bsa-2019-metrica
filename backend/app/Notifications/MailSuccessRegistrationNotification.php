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

    public function __construct(User $user)
    {
        $this->user = $user;
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
        $link = url('/reset-password');
        return (new MailMessage)
            ->subject('Confirmation of registration')
            ->line("Dear {$this->user->name},")
            ->line("Thank you for registering to Metrica service. Your registration was successful.")
            ->line("You registered with this email: {$this->user->email}.")
            ->line("If you forgot your password, simply hit Forgot password and you'll be prompted to reset it.  ")
            ->action('Forgot password', $link)
            ->line("If you have any questions, feel free to reply to this email.");
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
