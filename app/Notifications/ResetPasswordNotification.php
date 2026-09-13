<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends BaseResetPassword
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject(config('app.name') . ' · Reset Your Password')
            ->view('emails.auth.reset-password', [
                'url'        => $url,
                'user'       => $notifiable,
                'expireTime' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'),
                'appName'    => config('app.name'),
                'appUrl'     => config('app.url'),
            ]);
    }
}
