<?php

namespace App\Listeners;

use App\Events\Site\Deployed;
use App\Services\ProgressService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SiteDeployedProgress
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Deployed $event)
    {
        ProgressService::finish("deploy_{$event->getSite()->name}");
    }
}
