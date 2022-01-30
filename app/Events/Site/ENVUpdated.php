<?php

namespace App\Events\Site;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ENVUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $siteName;
    private string $envContents;

    /**
     * Create a new event instance.
     *
     * @param string $siteName
     * @param string $envContents
     * @return void
     */
    public function __construct(string $siteName, string $envContents)
    {
        $this->siteName = $siteName;
        $this->envContents = $envContents;
    }

}
