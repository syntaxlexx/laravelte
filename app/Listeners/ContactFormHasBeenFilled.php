<?php

namespace App\Listeners;

use App\Mail\ContactFormMailable;
use App\Notifications\NotifyAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class ContactFormHasBeenFilled implements ShouldQueue
{
    public $tries = 3;
    public $timeout = 120;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $contactMessage = $event->contactMessage;

        // send mail
        if($contactMessage->email) {
            Mail::to($contactMessage->email)
                ->send(new ContactFormMailable($contactMessage));
        }

        // notify admins
        foreach(adminUsers() as $admin)
        {
            $admin->notify(new NotifyAdmin($contactMessage->name . " just left a message", $contactMessage->subject));
        }
    }
}
