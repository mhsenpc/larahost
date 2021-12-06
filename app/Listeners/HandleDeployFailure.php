<?php

namespace App\Listeners;

use App\Events\DeployFailed;
use App\Models\User;
use App\Notifications\DeployFailureNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;

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
       Notification::send($event->site->user_id, new DeployFailureNotification($event->site));
    }
}
