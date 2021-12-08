<?php

namespace App\Listeners;


use App\Events\Site\DeployFailed;
use App\Models\User;
use App\Notifications\DeployFailureNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class HandleDeployFailure
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(DeployFailed $event)
    {
       Notification::send($event->site->user, new DeployFailureNotification($event->site));
    }
}
