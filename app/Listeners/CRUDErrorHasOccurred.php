<?php

namespace App\Listeners;

use App\Notifications\CrudErrorNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notification;

class CRUDErrorHasOccurred
{
    public $tries = 3;
    public $timeout = 120;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if(config('logging.allow_slack_crud_notifications')) {

            Notification::route('slack', config('logging.channels.slack.url'))
                ->notify(new CrudErrorNotification($event->error));
        }
    }
}
