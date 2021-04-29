<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use App\Services\Google;
// use Illuminate\Support\Facades\View;

class QbServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('QbService', function ($app) {
            return new \App\Services\QbService();
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
