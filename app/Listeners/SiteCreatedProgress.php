<?php

namespace App\Listeners;

use App\Events\Site\Created;
use App\Services\ProgressService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SiteCreatedProgress
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Created $event)
    {
        ProgressService::finish("create_{$event->getSite()->name}");
    }
}
