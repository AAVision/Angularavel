<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NgBuildServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('App\Services\NgBuildService', function ($app) {
            return new NgBuildService();
        });
    }
}
