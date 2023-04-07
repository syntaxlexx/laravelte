<?php

namespace App\Notifications;

use App\Traits\QueueMailConstants;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUserOfPasswordHardReset extends Notification
{
    use Queueable;
    use QueueMailConstants;

    public $password;

    public $tries = 3;
    public $timeout = 120;

    /**
     * Create a new notification instance.
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = new MailMessage;
        $config = $this->noReplyEmail();
        $subject = 'Password Updated!';
        $markdown = "emails.password-hard-reset";

        $message
            ->from($config['email'], $config['name'])
            ->subject($subject)
            ->markdown($markdown, [
                'support_name' => "Support",
                'support_position' => 'Head Office',
                'user' => $notifiable,
                'password' => $this->password,
                'actionText' => 'Login',
                'actionUrl' => route('login'),
            ]);

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
