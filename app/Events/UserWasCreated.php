<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $ipAddress;

    /**
     * User|null admin. If missing, the user was created by the system/registration)
     */
    public $admin;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $ipAddress, $admin = null)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
        $this->admin = $admin;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
