<?php

namespace App\Events\Site;


use App\Models\Site;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeployFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * @var Site
     */
    public $site;
    public $failureMessage;

    public function __construct(Site $site,string $failureMessage)
    {
        $this->site = $site;
        $this->failureMessage = $failureMessage;
    }

}
