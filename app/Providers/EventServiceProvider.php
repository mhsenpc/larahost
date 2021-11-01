<?php

namespace App\Providers;

use App\Events\Site\Created;
use App\Events\Site\Creating;
use App\Events\Site\Deployed;
use App\Events\Site\Deploying;
use App\Listeners\SiteCreatedProgress;
use App\Listeners\SiteCreatingProgress;
use App\Listeners\SiteDeployingProgress;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Creating::class => [
            SiteCreatingProgress::class
        ],
        Created::class => [
            SiteCreatedProgress::class
        ],
        Deploying::class =>[
            SiteDeployingProgress::class
        ],
        Deployed::class =>[
            SiteDeployingProgress::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
