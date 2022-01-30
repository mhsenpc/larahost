<?php

namespace App\Listeners;

use App\Events\Site\Deploying;
use App\Services\ProgressService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SiteDeployingProgress
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Deploying $event)
    {
        ProgressService::start("deploy_{$event->getSite()->name}");
    }
}
