<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorAuthNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $code) {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage {
        return (new MailMessage)
            ->subject('Authentication Code')
            ->line('Here is your one time password: ' . $this->code)
            ->line('This code is valid for 10 minutes');
    }

}
