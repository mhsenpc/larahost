<?php

namespace App\Events\Site;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deploying
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private \App\Models\Site $site;

    /**
     * @return \App\Models\Site
     */
    public function getSite(): \App\Models\Site {
        return $this->site;
    }

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Site $site
     * @param string $siteName
     * @return void
     */
    public function __construct(\App\Models\Site $site)
    {
        $this->site = $site;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('site-deploying');
    }
}
