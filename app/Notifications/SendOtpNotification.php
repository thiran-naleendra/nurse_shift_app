<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpNotification extends Notification
{
    use Queueable;

    protected string $otpCode;

    public function __construct(string $otpCode)
    {
        $this->otpCode = $otpCode;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your OTP Verification Code')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your OTP code is: ' . $this->otpCode)
            ->line('This OTP will expire in 10 minutes.')
            ->line('If you did not create this account, you can ignore this email.');
    }
}