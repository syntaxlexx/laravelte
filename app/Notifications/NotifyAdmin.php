<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAdmin extends Notification
{
    use Queueable;

    public $tries = 3;
    public $timeout = 120;

    public $title, $message, $ipAddress, $link;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        string $title,
        string $message,
        $link = '#',
        $ipAddress = null
    )
    {
        $this->title = $title;
        $this->message = $message;
        $this->link = $link;
        $this->ipAddress = $ipAddress;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // return $notifiable->prefers_sms ? ['nexmo'] : ['mail', 'database'];
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'link' => $this->link,
            'ip_address' => $this->ipAddress,
        ];
    }
}
