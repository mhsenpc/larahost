<?php

namespace App\Events\Site;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MaintenaceDown
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $siteName;

    /**
     * Create a new event instance.
     *
     * @param string $siteName
     * @return void
     */
    public function __construct(string $siteName)
    {
        //
        $this->siteName = $siteName;
    }
}
