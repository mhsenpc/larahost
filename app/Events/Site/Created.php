<?php

namespace App\Events\Site;

use App\Models\Site;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $site_id;
    public $site_name;
    protected $user_id;
    private $site;

    /**
     * Create a new event instance.
     *
     * @param $site
     */
    public function __construct(Site $site) {
        $this->site_id = $site->id;
        $this->site_name = $site->name;
        $this->user_id = $site->user_id;
        $this->site = $site;
    }

    /**
     * @return mixed
     */
    public function getSite() {
        return $this->site;
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
