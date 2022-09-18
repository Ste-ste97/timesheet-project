<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorAuthNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private string $code)
    {
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject('Authentication Code')
            ->line('Here is your one time password: ' . $this->code)
            ->line('This code is valid for 10 minutes');
    }

}
