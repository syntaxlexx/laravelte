<?php

namespace App\Listeners;

use App\Jobs\SendLoginAlertEmail;
use App\Models\UserLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserHasLoggedIn
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
        $user = $event->user;
        $requestData = $event->requestData;

        $userLogin = new UserLogin();
        $userLogin->user_id = $user->id;
        $userLogin->ip_address = $requestData['ip'];
        $userLogin->user_agent = $requestData['user_agent'];
        $userLogin->referer = $requestData['referer'];
        $userLogin->host = $requestData['host'];
        $userLogin->notes = 'Device name: ' . $requestData['device_name'];
        $userLogin->save();

        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $requestData['ip'],
        ]);

        dispatch(new SendLoginAlertEmail($user, $requestData));

    }
}
