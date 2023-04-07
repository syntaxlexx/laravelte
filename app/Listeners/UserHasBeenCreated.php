<?php

namespace App\Listeners;

use App\Notifications\NotifyAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserHasBeenCreated implements ShouldQueue
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
        $user = $event->user;
        $ipAddress = $event->ipAddress;
        $admin = $event->admin;

        // notify admins
        foreach(adminUsers() as $admin)
        {
            $message = $admin
                ? $admin->aka . " added a new user in the system."
                : "Email: " . $user->email;

            $admin->notify(new NotifyAdmin($user->aka . "'s account has just been created!", $message, '#', $ipAddress));
        }

    }
}
