<?php

namespace App\Jobs;

use App\Notifications\NotifyUserOfLogin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendLoginAlertEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user, $requestData;

    public $tries = 3;
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, array $requestData)
    {
        $this->user = $user;
        $this->requestData = $requestData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // send notification
        if($this->user->created_at >= now()->subMinutes(5)) {
            // user recently added or not active. No need to send an alert

            // log the activity
            if($this->user->isSudo)
                Log::channel('sudo-logins')->info('New user login. Email: ' . $this->user->email);
            else
                Log::channel('user-logins')->info('New user login. Email: ' . $this->user->email);

        } else {
            $this->user->notify(new NotifyUserOfLogin($this->requestData));
        }
    }
}
