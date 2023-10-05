<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;
class MailResetPasswordNotification extends ResetPassword
{
    use Queueable;
    protected $pageUrl;
    public $token;
    /**
    * Create a new notification instance.
    *
    * @param $token
    */
    public function __construct($token)
    {
        parent::__construct($token);
        $this->pageUrl = config('app.url').'/reset-password';
            // we can set whatever we want here, or use .env to set environmental variables
        }
    /**
    * Get the notification's delivery channels.
    *
    * @param  mixed  $notifiable
    * @return array
    */
    public function via($notifiable)
    {
        return ['mail'];
    }
    /**
    * Get the mail representation of the notification.
    *
    * @param  mixed  $notifiable
    * @return \Illuminate\Notifications\Messages\MailMessage
    */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }
        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = url(route('customer.password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        }

        return $this->buildMailMessage($url);

    }
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Reset application Password'))
            ->line(Lang::get('You are receiving this email because of checking we received a password reset request for your account.'))
            ->action(Lang::get('Reset Password'), $this->pageUrl."?token=".$this->token)
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')]))
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
      // for customizing template
      // return (new MailMessage)->markdown('mail.reset.email',['url' => $url,'name' => $name,'email' => $email]);
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
            //
        ];
    }
}
