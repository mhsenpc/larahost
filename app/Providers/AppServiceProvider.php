<?php

namespace App\Providers;

use App\Models\Site;
use App\Services\ContainerInfoService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using closure based composers...
        View::composer('layouts.sidebars.main_sidebar', function ($view) {
            $user_sites = Site::query()->get();
            $view->with('user_sites', $user_sites);
        });

        View::composer(['layouts.sidebars.site_sidebar','site.show'], function ($view) {
            $running = ContainerInfoService::getPowerStatus($view->site->name);
            $view->with('running', $running);
        });
    }
}
