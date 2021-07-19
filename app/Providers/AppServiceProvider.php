<?php

namespace App\Providers;

use App\Models\Site;
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
        View::composer('layouts.main_sidebar', function ($view) {
            $user_sites = Site::query()->get();
            $view->with('user_sites', $user_sites);
        });
    }
}
