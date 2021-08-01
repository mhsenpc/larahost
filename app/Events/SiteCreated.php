<?php

namespace App\Events;

use App\Services\ProgressService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SiteCreated implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $site_id;
    public $site_name;
    private $user_id;

    /**
     * Create a new event instance.
     *
     * @param $site
     */
    public function __construct($site) {
        $this->site_id = $site->id;
        $this->site_name = $site->name;
        $this->user_id = $site->user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new Channel('user-' . $this->user_id);
    }

    public function broadcastAs() {
        return 'site.created';
    }
}
