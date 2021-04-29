<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use App\Services\Google;
// use Illuminate\Support\Facades\View;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Google', function ($app) {
            return new \App\Services\Google();
        });
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
