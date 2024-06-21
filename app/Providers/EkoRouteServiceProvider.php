<?php

namespace App\Providers;

use App\Decorators\EkoRoute;
use Illuminate\Support\ServiceProvider;

class EkoRouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('ekoRoute', function ($app) {
            return new EkoRoute($app['router']);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}
