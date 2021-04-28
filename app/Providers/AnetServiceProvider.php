<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use App\Services\Google;
// use Illuminate\Support\Facades\View;

class AnetServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('AnetService', function ($app) {
            return new \App\Services\AnetService();
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
