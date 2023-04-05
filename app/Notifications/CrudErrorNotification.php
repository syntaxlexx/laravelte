<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class CrudErrorNotification extends Notification
{
    use Queueable;

    public $tries = 3;
    public $timeout = 120;

    public $error;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $error)
    {
        $this->error = $error;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack(object $notifiable): SlackMessage
    {
        $message = "[" . config('app.name') . " CRUD Error] ";
        $message .= $this->error;

        return (new SlackMessage)
            // ->from(config('app.name'), ':anguished:')
            // ->to("#" . config('logging.channels.slack.url'))
            ->content($message);
    }
}
