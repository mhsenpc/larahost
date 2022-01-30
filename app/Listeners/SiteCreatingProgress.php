<?php

namespace App\Listeners;

use App\Events\Site\Creating;
use App\Services\ProgressService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SiteCreatingProgress
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Creating $event)
    {
        ProgressService::start("create_{$event->getSite()->name}");
    }
}
