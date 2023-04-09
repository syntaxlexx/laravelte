<?php

namespace App\Notifications;

use App\Traits\QueueMailConstants;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NotifyUserOfLogin extends Notification implements ShouldQueue
{
    use Queueable;
    use QueueMailConstants;

    public $tries = 3;
    public $timeout = 120;

    public $requestData;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @param array $requestData
     */
    public function __construct(array $requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return $notifiable->prefers_sms ? ['nexmo'] : ['mail', 'database'];
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
        // send an alert
        if($notifiable->is_sudo)
            Log::channel('sudo-logins')->info('Login Mail alert sent to ' . $notifiable->email);
        else
            Log::channel('user-logins')->info('Login Mail alert sent to ' . $notifiable->email);

        $message = new MailMessage;
        $config = $this->noReplyEmail();
        $subject = 'Login Alert! Review sign in';
        $markdown = "emails.user-login-alert";

        $message
            ->from($config['email'], $config['name'])
            ->subject($subject)
            ->markdown($markdown, [
                'user' => $notifiable,
                'actionText' => 'View Login Activity',
                'actionUrl' => route('dashboard'),
            ]);

        return $message;
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
